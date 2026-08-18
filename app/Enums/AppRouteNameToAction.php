<?php

namespace App\Enums;

enum AppRouteNameToAction: string
{
    case SignUp = 'auth.sign-up';
    case SignIn = 'auth.sign-in';

    case Like = 'chirps.like';
    case Edit = 'chirps.edit';
    case Store = 'chirps.store';
    case Update = 'chirps.update';
    case Destroy = 'chirps.destroy';

    case Profile = 'profile.show';

    public function label(): string
    {
        return match ($this) {
            self::SignUp => 'register',
            self::SignIn => 'login',

            self::Like => 'like or unlike a chirp',
            self::Edit => 'edit a chirp',
            self::Store => 'create a chirp',
            self::Update => 'update a chirp',
            self::Destroy => 'delete a chirp',

            self::Profile => 'view your profile',
        };
    }
}
