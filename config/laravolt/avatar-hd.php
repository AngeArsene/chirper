<?php

/*
|--------------------------------------------------------------------------
| HD Avatar Configuration
|--------------------------------------------------------------------------
*/

return [

    'hd' => [
        'enabled' => env('AVATAR_HD_ENABLED', true),
        'width' => env('AVATAR_HD_WIDTH', 512),
        'height' => env('AVATAR_HD_HEIGHT', 512),
        'fontSize' => env('AVATAR_HD_FONT_SIZE', 200),
        'quality' => [
            'png' => env('AVATAR_HD_PNG_QUALITY', 95),
            'jpg' => env('AVATAR_HD_JPG_QUALITY', 90),
            'webp' => env('AVATAR_HD_WEBP_QUALITY', 85),
        ],
        'antialiasing' => env('AVATAR_HD_ANTIALIASING', true),
        'dpi' => env('AVATAR_HD_DPI', 300),
    ],

    'export' => [
        'format' => env('AVATAR_EXPORT_FORMAT', 'png'),
        'path' => env('AVATAR_EXPORT_PATH', 'avatars'),
        'filename_pattern' => env('AVATAR_EXPORT_FILENAME', '{hash}_{timestamp}.{format}'),
        'multiple_formats' => env('AVATAR_EXPORT_MULTIPLE', false),
        'progressive_jpeg' => env('AVATAR_PROGRESSIVE_JPEG', true),
        'webp_lossless' => env('AVATAR_WEBP_LOSSLESS', false),
    ],

    'performance' => [
        'file_cache' => env('AVATAR_FILE_CACHE', true),
        'size_based_cache' => env('AVATAR_SIZE_CACHE', true),
        'preload_fonts' => env('AVATAR_PRELOAD_FONTS', true),
        'background_processing' => env('AVATAR_BACKGROUND_PROCESSING', false),
        'lazy_loading' => env('AVATAR_LAZY_LOADING', true),
        'compression' => [
            'png' => env('AVATAR_PNG_COMPRESSION', 6),
            'webp' => env('AVATAR_WEBP_COMPRESSION', 80),
        ],
    ],

    'storage' => [
        'auto_cleanup' => env('AVATAR_AUTO_CLEANUP', true),
        'max_age_days' => env('AVATAR_MAX_AGE_DAYS', 30),
        'max_storage_mb' => env('AVATAR_MAX_STORAGE_MB', 500),
        'disk' => env('AVATAR_STORAGE_DISK', 'local'),
        'cdn_url' => env('AVATAR_CDN_URL', null),
        'metrics' => env('AVATAR_STORAGE_METRICS', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | HD Themes — recolored to match the "chirper" ocean/stealth palette
    |--------------------------------------------------------------------------
    */
    'hd_themes' => [
        'chirper-ultra-hd' => [
            'width' => 1024,
            'height' => 1024,
            'fontSize' => 400,
            'backgrounds' => [
                '#0EA5E9', '#0284C7', '#0369A1', '#0891B2',
                '#0E7490', '#164E63', '#334155', '#475569',
                '#1E293B', '#0F172A',
            ],
            'foregrounds' => ['#FFFFFF'],
            'border' => [
                'size' => 4,
                'color' => 'background',
                'radius' => 0,
            ],
        ],
        'retina' => [
            'width' => 512,
            'height' => 512,
            'fontSize' => 200,
            'backgrounds' => [
                '#0EA5E9', '#0284C7', '#0369A1', '#0891B2',
                '#0E7490', '#164E63', '#334155', '#1E293B',
            ],
            'foregrounds' => ['#FFFFFF'],
        ],
        'material-hd' => [
            'width' => 384,
            'height' => 384,
            'fontSize' => 150,
            'shape' => 'circle',
            'backgrounds' => [
                '#0369A1', '#0891B2', '#164E63', '#334155',
                '#475569', '#1E293B', '#0F172A', '#0284C7',
            ],
            'foregrounds' => ['#FFFFFF'],
            'border' => [
                'size' => 2,
                'color' => 'background',
                'radius' => 0,
            ],
        ],
    ],

    'responsive_sizes' => [
        'thumbnail' => ['width' => 64, 'height' => 64, 'fontSize' => 24],
        'small' => ['width' => 128, 'height' => 128, 'fontSize' => 48],
        'medium' => ['width' => 256, 'height' => 256, 'fontSize' => 100],
        'large' => ['width' => 512, 'height' => 512, 'fontSize' => 200],
        'xl' => ['width' => 768, 'height' => 768, 'fontSize' => 300],
        'xxl' => ['width' => 1024, 'height' => 1024, 'fontSize' => 400],
    ],

    'features' => [
        'sprites' => env('AVATAR_SPRITES', false),
        'variations' => env('AVATAR_VARIATIONS', false),
        'placeholders' => env('AVATAR_PLACEHOLDERS', true),
        'aspect_ratios' => env('AVATAR_ASPECT_RATIOS', false),
        'watermark' => [
            'enabled' => env('AVATAR_WATERMARK', false),
            'text' => env('AVATAR_WATERMARK_TEXT', ''),
            'opacity' => env('AVATAR_WATERMARK_OPACITY', 0.3),
            'position' => env('AVATAR_WATERMARK_POSITION', 'bottom-right'),
        ],
    ],

    'api' => [
        'enabled' => env('AVATAR_API_ENABLED', true),
        'rate_limit' => env('AVATAR_API_RATE_LIMIT', 60),
        'cors' => env('AVATAR_API_CORS', true),
        'auth' => env('AVATAR_API_AUTH', false),
        'headers' => [
            'Cache-Control' => 'public, max-age=31536000',
            'Expires' => gmdate('D, d M Y H:i:s', time() + 31536000).' GMT',
        ],
    ],
];
