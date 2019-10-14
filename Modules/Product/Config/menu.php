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
                'route'      => 'product.size.index',
                'permission' => [],
                'class'      => '',
                'icon'       => 'fa fa-th-list',
                'name'       => 'sizes',
                'text'       => 'product::menu.sizes',
                'order'      => 2,
                'sub'        => []
            ]
        ]
    ]
    // [
    //     'route'      => 'product.event.index',
    //     'permission' => [],
    //     'class'      => '',
    //     'icon'       => 'fa fa-calendar',
    //     'name'       => 'groups',
    //     'text'       => 'product::menu.events',
    //     'order'      => 6,
    //     'sub'        => [
    //         [
    //             'route'      => 'product.sale.index',
    //             'permission' => [],
    //             'class'      => '',
    //             'icon'       => 'fa fa-level-down',
    //             'name'       => 'groups',
    //             'text'       => 'product::menu.sales',
    //             'order'      => 3,
    //             'sub'        => []
    //         ],
    //         [
    //             'route'      => 'product.event.index',
    //             'permission' => [],
    //             'class'      => '',
    //             'icon'       => 'fa fa-level-down',
    //             'name'       => 'groups',
    //             'text'       => 'product::menu.events',
    //             'order'      => 6,
    //             'sub'        => []
    //         ]
    //     ]
    // ]
];
