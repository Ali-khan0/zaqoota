<?php

use App\Broadcasting\DmLocationChannel;
use App\Models\Admin;
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

Broadcast::channel('admin.dispatch.module.{module}', function ($principal, string $module) {
    if (! $principal instanceof Admin) {
        return false;
    }

    if ((int) $principal->role_id === 1) {
        return in_array($module, ['food', 'grocery', 'pharmacy', 'ecommerce', 'parcel', 'ride_hailing'], true);
    }
    if ($principal->zone_id) {
        return false;
    }

    $permissions = json_decode((string) $principal->role?->modules, true) ?: [];
    $requiredPermission = $module === 'ride_hailing' ? 'settings' : 'order';

    return in_array($requiredPermission, $permissions, true);
});

Broadcast::channel('admin.dispatch.zone.{zoneId}.module.{module}', function ($principal, int $zoneId, string $module) {
    if (! $principal instanceof Admin || (int) $principal->zone_id !== $zoneId) {
        return false;
    }

    $permissions = json_decode((string) $principal->role?->modules, true) ?: [];
    $requiredPermission = $module === 'ride_hailing' ? 'settings' : 'order';

    return in_array($requiredPermission, $permissions, true);
});

Broadcast::channel('admin.dispatch.location.all', function ($principal) {
    if (! $principal instanceof Admin) {
        return false;
    }

    if ((int) $principal->role_id === 1) {
        return true;
    }
    if ($principal->zone_id) {
        return false;
    }

    $permissions = json_decode((string) $principal->role?->modules, true) ?: [];

    return in_array('order', $permissions, true)
        || in_array('settings', $permissions, true);
});

Broadcast::channel('admin.dispatch.location.zone.{zoneId}', function ($principal, int $zoneId) {
    if (! $principal instanceof Admin || (int) $principal->zone_id !== $zoneId) {
        return false;
    }

    $permissions = json_decode((string) $principal->role?->modules, true) ?: [];

    return in_array('order', $permissions, true) || in_array('settings', $permissions, true);
});
