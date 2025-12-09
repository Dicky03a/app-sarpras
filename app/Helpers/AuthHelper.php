<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('getDashboardRedirect')) {

    function getDashboardRedirect($user = null)
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return route('home');
        }

        if ($user->hasRole('superadmin')) {
            return route('admin.dashboard');
        }

        if ($user->hasRole('admin')) {
            return route('admin.dashboard');
        }

        return route('user.dashboard');
    }
}

if (!function_exists('getUserRole')) {

    function getUserRole($user = null)
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return 'guest';
        }

        $roles = $user->getRoleNames()->toArray();

        foreach (['superadmin', 'admin', 'user'] as $role) {
            if (in_array($role, $roles)) {
                return $role;
            }
        }

        return $roles[0] ?? 'user';
    }
}
