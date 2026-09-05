<?php

namespace App\Enums;

enum MessageableType: string
{
    case Chirp = 'chirp';
    case Comment = 'comment';

    public function placeholder(): string
    {
        return match ($this) {
            self::Chirp => 'What\'s on your mind?',
            self::Comment => 'Add a comment...',
        };
    }
}
