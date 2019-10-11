<?php

return [
    'products' => [
        'route'      => 'product.product.index',
        'permission' => [],
        'class'      => '',
        'icon'       => 'fa fa-briefcase',
        'name'       => 'products',
        'text'       => 'product::menu.products_title',
        'order'      => 7,
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
                'name'       => 'roles',
                'text'       => 'product::menu.categories',
                'order'      => 2,
                'sub'        => []
            ],
            [
                'route'      => 'product.sale.index',
                'permission' => [],
                'class'      => '',
                'icon'       => 'fa fa-level-down',
                'name'       => 'groups',
                'text'       => 'product::menu.sales',
                'order'      => 3,
                'sub'        => []
            ]
        ]
    ],
];
