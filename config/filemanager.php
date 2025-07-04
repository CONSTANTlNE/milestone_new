<?php

return [
    /**
    * URL path to admin panel.
    */
    'favicons' => [
        '32' => 'storage/defaults/favicons/favicon-32x32.png',
        '16' => 'storage/defaults/favicons/favicon-16x16.png',
        'apple' => 'storage/defaults/favicons/apple-touch-icon.png',
    ],

    'logos' => [
        'desktop'       => 'storage/defaults/logos/desktop-logo.png',
        'toggle'        => 'storage/defaults/logos/toggle-logo.png',
        'desktop_dark'  => 'storage/defaults/logos/desktop-dark.png',
        'toggle_dark'   => 'storage/defaults/logos/toggle-dark.png',
        'desktop_white' => 'storage/defaults/logos/desktop-white.png',
        'toggle_white'  => 'storage/defaults/logos/toggle-white.png',
    ],

    'default_auth_company_image' => 'storage/defaults/logos/auth-logo.png',
    'default_auth_loader' => 'storage/defaults/loaders/auth-loader.svg',
    'default_backend_image' => 'storage/defaults/default.jpg',
    'default_backend_avatar_image' => 'storage/defaults/avatar.jpg',
    'default_seo_image' => 'storage/defaults/default-seo.jpg',

    'sizes' => [
        '1' => '120x240',
        '2' => '240x480',
        '3' => '480x960',
    ],

    'base_path' => 'files',
    'base_trash_path' => 'files/trash',

  /**
   * URL path to admin panel.
   */
  'admin_path' => 'backend',
  'youtube_api_key' => '',
  'localization' => false,
  'self_editor_roles' => false,
  'image_watermark' => false, // 'img/watermark.png'
  'default_images' => [],
  'response_cache_enabled' => false,
];
