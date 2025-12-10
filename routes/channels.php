<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Admin SOS alerts channel - only admins can subscribe
Broadcast::channel('admin.sos-alerts', function ($user) {
    return Auth::check() && ($user->role === 'admin' || $user->is_admin);
});
