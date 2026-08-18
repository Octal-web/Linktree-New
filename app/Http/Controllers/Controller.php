<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

abstract class Controller
{
    public function __construct()
    {

        if (app('request')->route()->getPrefix() !== '/manager') {
            $notifyCookies = array_key_exists('notify-cookies', $_COOKIE);
            $rejectCookies = array_key_exists('reject-cookies', $_COOKIE);

            Inertia::share([
                'notifyCookies' => $notifyCookies,
                'rejectCookies' => $rejectCookies,
            ]);
        }
    }
}
