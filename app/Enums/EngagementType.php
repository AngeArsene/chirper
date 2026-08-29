<?php

namespace App\Enums;

enum EngagementType: string
{
    case Like = 'like';
    case Bookmark = 'bookmark';

    public function relation(): string
    {
        return match ($this) {
            self::Like => 'likes',
            self::Bookmark => 'bookmarks',
        };
    }

    public function pastTense(): string
    {
        return match ($this) {
            self::Like => 'liked',
            self::Bookmark => 'bookmarked',
        };
    }
}
