<?php

namespace App\Enums;

enum EngagementType: string
{
    case Like = 'like';
    case Bookmark = 'bookmark';

    public function pastTenseVerb(): string
    {
        return match ($this) {
            self::Like => 'liked',
            self::Bookmark => 'bookmarked',
        };
    }
}
