<?php

use Laravolt\Avatar\Generator\DefaultGenerator;

/*
 * Set specific configuration variables here
 */
return [

    'driver' => env('IMAGE_DRIVER', 'gd'),

    'cache' => [
        'enabled' => env('AVATAR_CACHE_ENABLED', false),
        'key_prefix' => 'avatar_',
        'duration' => env('AVATAR_CACHE_DURATION', 86400),
    ],

    'generator' => DefaultGenerator::class,

    'ascii' => false,

    // Circle to match the "avatar" wrapper used across every blade view
    'shape' => 'circle',

    // Bumped from 100 -> 256: crisper when scaled down to size-10 (messages)
    // or shown larger on the profile pages
    'width' => 256,
    'height' => 256,

    'responsive' => false,

    'chars' => 2,

    // Scaled to match the new 256px canvas (was 48 for 100px)
    'fontSize' => 90,

    // Cleaner look for 2-letter initials in a small circle
    'uppercase' => true,

    'rtl' => false,

    // Single font for visual consistency with the app's sans-serif UI
    'fonts' => [__DIR__.'/../fonts/OpenSans-Bold.ttf'],

    'foregrounds' => [
        '#FFFFFF',
    ],

    // Cool ocean/stealth-inspired palette (matches the old avatars.laravel.cloud vibes)
    'backgrounds' => [
        '#0EA5E9', // sky
        '#0284C7', // sky-dark
        '#0369A1', // sky-darker
        '#0891B2', // cyan
        '#0E7490', // cyan-dark
        '#164E63', // deep teal
        '#334155', // slate
        '#475569', // slate-light
        '#1E293B', // slate-dark (stealth)
        '#0F172A', // near-black slate (stealth)
    ],

    'border' => [
        'size' => 2,
        'color' => 'background',
        'radius' => 0,
    ],

    'theme' => ['chirper'],

    'themes' => [
        'chirper' => [
            'backgrounds' => [
                '#0EA5E9',
                '#0284C7',
                '#0369A1',
                '#0891B2',
                '#0E7490',
                '#164E63',
                '#334155',
                '#475569',
                '#1E293B',
                '#0F172A',
            ],
            'foregrounds' => ['#FFFFFF'],
        ],
        'grayscale-light' => [
            'backgrounds' => ['#edf2f7', '#e2e8f0', '#cbd5e0'],
            'foregrounds' => ['#a0aec0'],
        ],
        'grayscale-dark' => [
            'backgrounds' => ['#2d3748', '#4a5568', '#718096'],
            'foregrounds' => ['#e2e8f0'],
        ],
    ],
];
