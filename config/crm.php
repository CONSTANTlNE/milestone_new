<?php

return [

    'zones' => [
        ['id' => 1, 'title' => 'Top Banner'],
        ['id' => 2, 'title' => 'Bottom Banner'],
    ],

    'status' => [
        ['id' => 1, 'title' => 'admin.active'],//გააქტიურება
        ['id' => 0, 'title' => 'admin.disable'],//დაბლოკვა
    ],

    'icons' => [
        ['id' => 'pbmit-base-icon-facebook-f"', 'title' => 'Facebook - pbmit-base-icon-facebook-f'],
        ['id' => 'pbmit-base-icon-youtube-play', 'title' => 'Youtube - pbmit-base-icon-youtube-play'],
        ['id' => 'pbmit-base-icon-twitter-2', 'title' => 'X (Twitter) - pbmit-base-icon-twitter-2'],
        ['id' => 'pbmit-base-icon-instagram', 'title' => 'Instagram - pbmit-base-icon-instagram'],
        ['id' => 'pbmit-base-icon-tiktok', 'title' => 'Tiktok - pbmit-base-icon-tiktok'],
        ['id' => 'pbmit-base-icon-linkedin-in', 'title' => 'Linkedin - pbmit-base-icon-linkedin-in'],
        ['id' => 'pbmit-base-icon-whatsapp', 'title' => 'WhatsApp - pbmit-base-icon-whatsapp'],
        ['id' => 'weChat', 'title' => 'WeChat - disabled'],
        ['id' => 'telegram', 'title' => 'Telegram - disabled'],
        ['id' => 'snapchat', 'title' => 'Snapchat - disabled'],
    ],

    'templates' => [
        ['id' => 'frontend.pages.show', 'title' => 'admin.default_page'],
        ['id' => 'frontend.index', 'title' => 'admin.home_page'],
        ['id' => 'frontend.blogs.index', 'title' => 'admin.blogs_page'],
        ['id' => 'frontend.services.index', 'title' => 'admin.services_page'],
        ['id' => 'frontend.portfolios.index', 'title' => 'admin.portfolios_page'],
        ['id' => 'frontend.pages.contact', 'title' => 'admin.contact_page'],
        ['id' => 'frontend.pages.about', 'title' => 'admin.about_page'],
        ['id' => 'frontend.pages.faq', 'title' => 'admin.faq_page'],
    ]
];
