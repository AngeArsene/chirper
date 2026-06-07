<?php

namespace App\Enums;

enum ChirpRouteNameToAction: string
{
    case Edit = 'chirps.edit';
    case Store = 'chirps.store';
    case Update = 'chirps.update';
    case Destroy = 'chirps.destroy';

    public function label(): string
    {
        return match ($this) {
            self::Edit => 'edit',
            self::Store => 'create',
            self::Update => 'update',
            self::Destroy => 'delete',
        };
    }
}
