<?php

return [
    'orders' => [
        'route'      => 'order.index',
        'permission' => [],
        'class'      => '',
        'icon'       => 'fa fa-shopping-cart',
        'name'       => 'orders',
        'text'       => 'Đơn hàng',
        'order'      => 4,
        'sub'        => [
            // [
            //     'route'      => 'customer.index',
            //     'permission' => [],
            //     'class'      => '',
            //     'icon'       => 'fa fa-user',
            //     'name'       => 'users',
            //     'text'       => 'Khách hàng',
            //     'order'      => 1,
            //     'sub'        => []
            // ],
            [
                'route'      => 'order.index',
                'permission' => [],
                'class'      => '',
                'icon'       => 'fa fa-user',
                'name'       => 'users',
                'text'       => 'Đơn hàng',
                'order'      => 2,
                'sub'        => []
            ],
        ]
    ],
];
