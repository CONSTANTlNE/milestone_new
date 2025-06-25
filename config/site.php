<?php

return [

  /**
   * URL path to admin panel.
   */

  'admin_path' => 'backend',

  'youtube_api_key' => '',

  'localization' => false,

  'self_editor_roles' => false,

  'image_watermark' => false, // 'img/watermark.png'

  /**
   'large' => [
      'img/default-image-1.svg',
      'img/default-image-2.svg',
      'img/default-image-3.svg',
      'img/default-image-4.svg',
      'img/default-image-5.svg',
      'img/default-image-6.svg',
    ],
    'small' => [
      'img/default-image-small-1.svg',
      'img/default-image-small-2.svg',
      'img/default-image-small-3.svg',
      'img/default-image-small-4.svg',
      'img/default-image-small-5.svg',
      'img/default-image-small-6.svg',
    ]
   */
  'default_images' => [],

  'default_backend_image' => 'storage/defaults/default.jpg',
  'default_seo_image' => 'storage/defaults/default-seo.jpg',
  'response_cache_enabled' => false,
];