<?php

use App\Broadcasting\DmLocationChannel;
use App\Models\DeliveryMan;
use App\Models\RideRequest;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('private-user.location', function ($user, $deliveryManId) {
    return true;
});

Broadcast::channel('dm_location_.{id}', DmLocationChannel::class);

Broadcast::channel('ride.customer.{userId}', function ($principal, int $userId) {
    return $principal instanceof User && (int) $principal->id === $userId;
});

Broadcast::channel('ride.captain.{captainId}', function ($principal, int $captainId) {
    return $principal instanceof DeliveryMan && (int) $principal->id === $captainId;
});

Broadcast::channel('ride.trip.{rideId}', function ($principal, int $rideId) {
    $ride = RideRequest::query()->select(['id', 'user_id', 'delivery_man_id'])->find($rideId);

    return $ride && (($principal instanceof User && (int) $ride->user_id === (int) $principal->id)
        || ($principal instanceof DeliveryMan && (int) $ride->delivery_man_id === (int) $principal->id));
});
