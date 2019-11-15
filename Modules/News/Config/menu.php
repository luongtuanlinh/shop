<?php

return [
    'news_manager' => [
        'text'      => 'news::menu.news_manager',
        'class'     => '',
        'icon'      => 'fa fa-newspaper-o',
        'order'     => 10,
        'permission' => [],
        'sub'       => [
            'news_posts' => [
                'route'      => 'news.news_post.index',
                'permission' => [],
                'class'      => '',
                'icon'       => 'fa fa-newspaper-o',
                'name'       => 'news_posts',
                'text'       => 'news::menu.news_posts',
                'order'      => 3,
                'sub'        => []
            ],
        ]
    ],
];
