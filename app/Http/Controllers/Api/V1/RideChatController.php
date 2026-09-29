<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\RideRequest;
use App\Services\RideCaptainEligibilityService;
use App\Services\RideChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RideChatController extends Controller
{
    public function __construct(
        private readonly RideChatService $chat,
        private readonly RideCaptainEligibilityService $eligibility,
    ) {}

    public function customerMessages(Request $request, int $rideId) { return $this->messages($request, $this->customerRide($request, $rideId), 'customer'); }
    public function captainMessages(Request $request, int $rideId) { return $this->messages($request, $this->captainRide($request, $rideId), 'captain'); }
    public function customerSend(Request $request, int $rideId) { return $this->send($request, $this->customerRide($request, $rideId), 'customer', (int) $request->user()->id); }
    public function captainSend(Request $request, int $rideId) { $captain = $this->captain($request); return $this->send($request, $this->captainRide($request, $rideId), 'captain', (int) $captain->id); }
    public function customerSeen(Request $request, int $rideId) { return $this->seen($this->customerRide($request, $rideId), 'customer', (int) $request->user()->id); }
    public function captainSeen(Request $request, int $rideId) { $captain = $this->captain($request); return $this->seen($this->captainRide($request, $rideId), 'captain', (int) $captain->id); }
    public function customerPresence(Request $request, int $rideId) { return $this->presence($request, $this->customerRide($request, $rideId), 'customer', (int) $request->user()->id); }
    public function captainPresence(Request $request, int $rideId) { $captain = $this->captain($request); return $this->presence($request, $this->captainRide($request, $rideId), 'captain', (int) $captain->id); }

    private function messages(Request $request, RideRequest $ride, string $viewerType)
    {
        $messages = $this->chat->messages($ride, $request->integer('limit', 30));
        return response()->json([
            'messages' => collect($messages->items())->map(fn ($message) => $this->chat->data($message))->values(),
            'current_page' => $messages->currentPage(),
            'last_page' => $messages->lastPage(),
            'total' => $messages->total(),
            'can_send' => $this->chat->canSend($ride),
            'read_only' => ! $this->chat->canSend($ride),
            'ride_status' => $ride->status,
            'contact' => $this->contactData($ride, $viewerType),
        ]);
    }

    private function send(Request $request, RideRequest $ride, string $type, int $id)
    {
        $validator = Validator::make($request->all(), ['client_id' => 'required|string|max:64', 'message' => 'required|string|max:1000']);
        if ($validator->fails()) return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        [$message, $created] = $this->chat->send($ride, $type, $id, $request->string('client_id')->toString(), $request->string('message')->toString());
        return response()->json(['message' => $this->chat->data($message)], $created ? 201 : 200);
    }

    private function seen(RideRequest $ride, string $type, int $id) { return response()->json(['seen_count' => $this->chat->markSeen($ride, $type, $id)]); }

    private function presence(Request $request, RideRequest $ride, string $type, int $id)
    {
        $validator = Validator::make($request->all(), ['active' => 'required|boolean']);
        if ($validator->fails()) return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        $active = $this->chat->presence($ride, $type, $id, $request->boolean('active'));
        return response()->json(['active' => $active, 'can_send' => $this->chat->canSend($ride)]);
    }

    private function customerRide(Request $request, int $rideId): RideRequest
    {
        return RideRequest::query()->where('user_id', $request->user()->id)->whereNotNull('delivery_man_id')->with(['user', 'deliveryMan'])->findOrFail($rideId);
    }

    private function captainRide(Request $request, int $rideId): RideRequest
    {
        $captain = $this->captain($request);
        return RideRequest::query()->where('delivery_man_id', $captain->id)->with(['user', 'deliveryMan'])->findOrFail($rideId);
    }

    private function captain(Request $request)
    {
        return $this->eligibility->captainByToken($request->token) ?? abort(401);
    }

    private function contactData(RideRequest $ride, string $viewerType): ?array
    {
        $customerName = trim(($ride->user?->f_name ?? '').' '.($ride->user?->l_name ?? ''));
        $captainName = trim((string) ($ride->deliveryMan?->full_name ?? ''));
        $contact = $viewerType === 'customer' ? $ride->deliveryMan : $ride->user;
        if (! $contact) {
            return null;
        }

        return [
            'name' => $viewerType === 'customer' ? $captainName : $customerName,
            'phone' => (string) ($contact->phone ?? ''),
            'sender_name' => $viewerType === 'customer' ? $customerName : $captainName,
            'ride_number' => (string) $ride->request_number,
            'destination_name' => (string) $ride->destination_address,
        ];
    }
}
