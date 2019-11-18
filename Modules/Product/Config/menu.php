<?php

return [
    'products' => [
        'route'      => 'product.product.index',
        'permission' => [],
        'class'      => '',
        'icon'       => 'fa fa-briefcase',
        'name'       => 'products',
        'text'       => 'product::menu.products_title',
        'order'      => 5,
        'sub'        => [
            [
                'route'      => 'product.product.index',
                'permission' => [],
                'class'      => '',
                'icon'       => 'fa fa-briefcase',
                'name'       => 'products',
                'text'       => 'product::menu.products',
                'order'      => 1,
                'sub'        => []
            ],
            [
                'route'      => 'product.category.index',
                'permission' => [],
                'class'      => '',
                'icon'       => 'fa fa-th-list',
                'name'       => 'categories',
                'text'       => 'product::menu.categories',
                'order'      => 2,
                'sub'        => []
            ],
            [
                'route'      => 'product.choose',
                'permission' => [],
                'class'      => '',
                'icon'       => 'fa fa-th-list',
                'name'       => 'chooses',
                'text'       => 'product::menu.chooses',
                'order'      => 2,
                'sub'        => []
            ]
        ]
    ]
];
