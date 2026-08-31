<?php

namespace App\Enums;

enum EngagementType: string
{
    case Like = 'like';
    case Comment = 'comment';
    case Bookmark = 'bookmark';

    public function relation(): string
    {
        return match ($this) {
            self::Like => 'likes',
            self::Comment => 'comments',
            self::Bookmark => 'bookmarks',
        };
    }

    public function pastTense(): string
    {
        return match ($this) {
            self::Like => 'liked',
            self::Comment => 'Commented',
            self::Bookmark => 'bookmarked',
        };
    }
}
