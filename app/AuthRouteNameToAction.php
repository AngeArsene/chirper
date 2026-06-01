<?php

namespace App;

enum AuthRouteNameToAction: string
{
    case SignUp = 'auth.sign-up';
    case SignIn = 'auth.sign-in';

    public function label(): string
    {
        return match($this) {
            self::SignUp => 'register',
            self::SignIn => 'login',
        };
    }
}
