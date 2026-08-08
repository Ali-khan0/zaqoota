<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DeliveryMan;
use App\Models\FleetManager;
use App\Services\DeliveryManRegistrationFeeService;
use App\Services\RideVehicleRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class DeliveryManLoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $rawPhone = trim((string) $request->phone);
        $password = $request->password;

        $phoneCandidates = [
            $rawPhone,
            ltrim($rawPhone, '+'),
            '+' . ltrim($rawPhone, '+'),
        ];
        $digitsOnly = preg_replace('/\D/', '', $rawPhone);
        if ($digitsOnly !== '') {
            $phoneCandidates[] = $digitsOnly;
            if (str_starts_with($digitsOnly, '92')) {
                $phoneCandidates[] = '0' . substr($digitsOnly, 2);
            }
            if (str_starts_with($digitsOnly, '0')) {
                $phoneCandidates[] = '92' . ltrim($digitsOnly, '0');
                $phoneCandidates[] = '+' . '92' . ltrim($digitsOnly, '0');
            }
        }
        
        $phoneCandidates = array_values(array_unique(array_filter($phoneCandidates, static fn ($p) => $p !== null && $p !== '')));

        $fleetManager = FleetManager::query()
            ->where(function ($query) use ($phoneCandidates) {
                foreach ($phoneCandidates as $phone) {
                    $query->orWhere('phone', $phone);
                }
            })
            ->first();

        if ($fleetManager && Hash::check($password, $fleetManager->password)) {
            if (! $fleetManager->status || $fleetManager->on_leave) {
                return response()->json([
                    'errors' => [
                        ['code' => 'auth-003', 'message' => __('fleet_management.error_manager_unavailable')],
                    ],
                ], 401);
            }

            $token = Str::random(120);
            $fleetManager->update(['auth_token' => $token]);

            return response()->json([
                'token' => $token,
                'account_type' => 'fleet_manager',
                'topic' => 'fleet_manager_'.$fleetManager->id,
                'zone_topic' => '',
            ]);
        }

        $delivery_man = DeliveryMan::withoutGlobalScopes()
            ->where(function ($q) use ($phoneCandidates) {
                foreach ($phoneCandidates as $p) {
                    $q->orWhere('phone', $p);
                }
            })
            ->first();

        if (! $delivery_man || ! Hash::check($password, $delivery_man->password)) {
            return response()->json([
                'errors' => [
                    ['code' => 'auth-001', 'message' => translate('Incorrect_credential,_please_try_again')],
                ],
            ], 401);
        }

        if ($delivery_man->application_status != 'approved') {
            return response()->json([
                'errors' => [
                    ['code' => 'auth-003', 'message' => translate('messages.Your_account_is_not_approved_yet.')],
                ],
            ], 401);
        }

        if (! $delivery_man->status) {
            return response()->json([
                'errors' => [
                    ['code' => 'auth-003', 'message' => translate('messages.your_account_has_been_suspended')],
                ],
            ], 401);
        }

        $token = Str::random(120);
        $delivery_man->auth_token = $token;
        $delivery_man->save();

        $delivery_man->loadMissing('zone');

        $zone_topic = '';
        $topic = 'restaurant_dm_'.$delivery_man?->store_id;
        if (isset($delivery_man->zone)) {
            if ($delivery_man->vehicle_id) {
                $topic = 'delivery_man_'.$delivery_man->zone->id.'_'.$delivery_man->vehicle_id;
            } else {
                $topic = $delivery_man->type == 'zone_wise' ? $delivery_man->zone->deliveryman_wise_topic : 'restaurant_dm_'.$delivery_man->store_id;
            }
            $zone_topic = $delivery_man->type == 'zone_wise' ? $delivery_man->zone->deliveryman_wise_topic.'_push' : '';
        }

        return response()->json([
            'token' => $token,
            'account_type' => 'rider',
            'topic' => isset($topic) ? $topic : 'No_topic_found',
            'zone_topic' => $zone_topic ?? '',
        ], 200);
    }

    public function store(Request $request)
    {
        $vehicleService = app(RideVehicleRegistrationService::class);
        $validator = Validator::make($request->all(), [
            'f_name' => 'required',
            'identity_type' => 'required|in:passport,driving_license,nid',
            'identity_number' => 'required',
            'email' => 'required|unique:delivery_men',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:delivery_men',
            'password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'zone_id' => 'required',
            ...$vehicleService->rules(),
        ], [
            'f_name.required' => translate('messages.first_name_is_required'),
            'zone_id.required' => translate('messages.select_a_zone'),
            'ride_vehicle_type_id.required' => translate('messages.select_a_vehicle'),
            'password.required' => translate('The password is required'),
            'password.min_length' => translate('The password must be at least :min characters long'),
            'password.mixed' => translate('The password must contain both uppercase and lowercase letters'),
            'password.letters' => translate('The password must contain letters'),
            'password.numbers' => translate('The password must contain numbers'),
            'password.symbols' => translate('The password must contain symbols'),
            'password.uncompromised' => translate('The password is compromised. Please choose a different one'),

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)],403);
        }

        if ($request->has('image')) {
            $image_name = Helpers::upload('delivery-man/', 'png', $request->file('image'));
        } else {
            $image_name = 'def.png';
        }

        $id_img_names = [];
        if (!empty($request->file('identity_image'))) {
            foreach ($request->identity_image as $img) {
                $identity_image = Helpers::upload('delivery-man/', 'png', $img);
                array_push($id_img_names, ['img'=>$identity_image, 'storage'=> Helpers::getDisk()]);
            }
            $identity_image = json_encode($id_img_names);
        } else {
            $identity_image = json_encode([]);
        }

        $dm = DB::transaction(function () use ($request, $identity_image, $image_name, $vehicleService) {
            $dm = new DeliveryMan();
            $dm->f_name = $request->f_name;
            $dm->l_name = $request->l_name;
            $dm->email = $request->email;
            $dm->phone = $request->phone;
            $dm->identity_number = $request->identity_number;
            $dm->identity_type = $request->identity_type;
            $dm->identity_image = $identity_image;
            $dm->vehicle_id = $vehicleService->matchingDeliveryVehicleId((int) $request->ride_vehicle_type_id);
            $dm->image = $image_name;
            $dm->status = 0;
            $dm->active = 0;
            $dm->application_status = 'pending';
            $dm->zone_id = $request->zone_id;
            $dm->earning = 1;
            $dm->password = bcrypt($request->password);
            $dm->save();

            $vehicleService->createPendingVehicle($dm, $request->only(array_keys($vehicleService->rules())));

            return $dm;
        });
        
        app(DeliveryManRegistrationFeeService::class)->ensureRecordForDeliveryMan($dm->id);
        
        try{
            $admin= Admin::where('role_id', 1)->first();
            $mail_status = Helpers::get_mail_status('registration_mail_status_dm');
            if(config('mail.status') && $mail_status == '1' && Helpers::getNotificationStatusData('deliveryman','deliveryman_registration','mail_status')){
                Mail::to($request->email)->send(new \App\Mail\DmSelfRegistration('pending', $dm->f_name.' '.$dm->l_name));
            }
            $mail_status = Helpers::get_mail_status('dm_registration_mail_status_admin');
            if(config('mail.status') && $mail_status == '1' && Helpers::getNotificationStatusData('admin','deliveryman_self_registration','mail_status')){
                Mail::to($admin['email'])->send(new \App\Mail\DmRegistration('pending', $dm->f_name.' '.$dm->l_name));
            }
        }catch(\Exception $ex){
            info($ex->getMessage());
        }

        return response()->json(['message' => translate('messages.deliveryman_added_successfully')], 200);
    }
}
