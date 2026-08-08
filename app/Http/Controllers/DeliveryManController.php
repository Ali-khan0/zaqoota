<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use App\Services\DeliveryManRegistrationFeeService;
use App\Services\RideVehicleRegistrationService;
use App\Models\RideVehicleType;
use App\Models\Admin;
use App\Models\BusinessSetting;
use Gregwar\Captcha\CaptchaBuilder;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class DeliveryManController extends Controller
{

    public function create()
    {
        $status = BusinessSetting::where('key', 'toggle_dm_registration')->first();
        if(!isset($status) || $status->value == '0')
        {
            Toastr::error(translate('messages.not_found'));
            return back();
        }

        $custome_recaptcha = new CaptchaBuilder;
        $custome_recaptcha->build();
        Session::put('six_captcha', $custome_recaptcha->getPhrase());

        $rideVehicleTypes = RideVehicleType::query()
            ->where('status', true)
            ->with(['categories' => fn ($query) => $query->where('status', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('dm-registration', compact('custome_recaptcha', 'rideVehicleTypes'));
    }

    public function store(Request $request)
    {
        $status = BusinessSetting::where('key', 'toggle_dm_registration')->first();
        if(!isset($status) || $status->value == '0')
        {
            Toastr::error(translate('messages.not_found'));
            return back();
        }

        $recaptcha = Helpers::get_business_settings('recaptcha');
        if (isset($recaptcha) && $recaptcha['status'] == 1) {
            $request->validate([
                'g-recaptcha-response' => [
                    function ($attribute, $value, $fail) {
                        $secret_key = Helpers::get_business_settings('recaptcha')['secret_key'];
                        $gResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                            'secret' => $secret_key,
                            'response' => $value,
                            'remoteip' => \request()->ip(),
                        ]);

                        if (!$gResponse->successful()) {
                            $fail(translate('ReCaptcha Failed'));
                        }
                    },
                ],
            ]);
        } else if(session('six_captcha') != $request->custome_recaptcha)
        {
            Toastr::error(trans('messages.ReCAPTCHA Failed'));
            return back();
        }

        $vehicleService = app(RideVehicleRegistrationService::class);
        $request->validate([
            'f_name' => 'required|max:100',
            'l_name' => 'nullable|max:100',
            'identity_type' => 'required|in:passport,driving_license,nid',
            'identity_number' => 'required|max:30',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'identity_image' => 'required|array|min:1|max:2',
            'identity_image.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'email' => 'required|unique:delivery_men',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:delivery_men',
            'zone_id' => 'required',
            'password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            ...$vehicleService->rules(),
        ], [
            'f_name.required' => translate('messages.first_name_is_required'),
            'zone_id.required' => translate('messages.select_a_zone'),
            'ride_vehicle_type_id.required' => translate('messages.select_a_vehicle')
        ]);

        $image_name = Helpers::upload('delivery-man/', 'png', $request->file('image'));

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
            $dm->vehicle_id = $vehicleService->matchingDeliveryVehicleId((int) $request->ride_vehicle_type_id);
            $dm->zone_id = $request->zone_id;
            $dm->identity_image = $identity_image;
            $dm->image = $image_name;
            $dm->active = 0;
            $dm->status = 0;
            $dm->earning = 1;
            $dm->password = bcrypt($request->password);
            $dm->application_status = 'pending';
            $dm->save();

            $vehicleService->createPendingVehicle($dm, $request->only(array_keys($vehicleService->rules())));

            return $dm;
        });


        app(DeliveryManRegistrationFeeService::class)->ensureRecordForDeliveryMan($dm->id);

        try{
            $admin= Admin::where('role_id', 1)->first();

            if(config('mail.status') &&  Helpers::get_mail_status('registration_mail_status_dm') == '1' && Helpers::getNotificationStatusData('deliveryman','deliveryman_registration','mail_status')  ){
                Mail::to($request->email)->send(new \App\Mail\DmSelfRegistration('pending', $dm->f_name.' '.$dm->l_name));
            }
            if(config('mail.status') && Helpers::get_mail_status('dm_registration_mail_status_admin') == '1' && Helpers::getNotificationStatusData('admin','deliveryman_self_registration','mail_status')) {
                Mail::to($admin['email'])->send(new \App\Mail\DmRegistration('pending', $dm->f_name.' '.$dm->l_name));
            }
        }catch(\Exception $ex){
            info($ex->getMessage());
        }
        Toastr::success(translate('messages.application_placed_successfully'));
        return back();
    }
}
