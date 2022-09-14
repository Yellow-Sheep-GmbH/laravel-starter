<?php

return [
    'locale' => 'de',
    'fallback_locale' => 'en',
    'auto_seed_singletons' => true,
    'auth_login_redirect_path' => "/admin",
    'enabled' => [
        'users-management' => true,
        'media-library' => true,
        'file-library' => true,
        'block-editor' => true,
        'buckets' => false,
        'users-image' => false,
        'settings' => true,
        'dashboard' => true,
        'search' => true,
        'users-description' => true,
        'activitylog' => false,
        'users-2fa' => false,
        'users-oauth' => false,
    ],
    'publish_date_24h' => true,
    'publish_date_format' => 'd F Y H:i',
    'publish_date_display_format' => 'DD MMMM YYYY HH:mm',
    'media_library' => [
        'init_alt_text_from_filename' => false,
        'allowed_extensions' => ['JPG', 'PNG', 'GIF', "JPEG"]
    ],
    'block_editor' => [
        'block_views_path' => 'block_editor.blocks',
        'block_single_layout' => 'block_editor.layout',
        'files' => [],
        'browser_route_prefixes' => [
            'pages' => 'pages',
            'posts' => 'blog',
            'references' => 'blog',
        ],
        'crops' => [
            'image' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => 0,
                        'minValues' => [
                            'width' => 500,
                            'height' => 500,
                        ],
                    ],
                ],
            ],
        ]
    ]
];
