<?php

return [
    'products' => [
        'route'      => 'product.product.index',
        'permission' => [8,9,10,11],
        'class'      => '',
        'icon'       => 'fa fa-briefcase',
        'name'       => 'products',
        'text'       => 'product::menu.products_title',
        'order'      => 7,
        'sub'        => [
            [
                'route'      => 'product.product.index',
                'permission' => [8,9,10,11],
                'class'      => '',
                'icon'       => 'fa fa-briefcase',
                'name'       => 'products',
                'text'       => 'product::menu.products',
                'order'      => 1,
                'sub'        => []
            ],
            [
                'route'      => 'product.category.index',
                'permission' => [12,13,14,15],
                'class'      => '',
                'icon'       => 'fa fa-th-list',
                'name'       => 'roles',
                'text'       => 'product::menu.categories',
                'order'      => 2,
                'sub'        => []
            ],
            [
                'route'      => 'product.sale.index',
                'permission' => [16,17,18,19],
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
