<?php

return [
    'users' => [
        'route'      => 'core.user.index',
        'permission' => [8,9,10,11],
        'class'      => '',
        'icon'       => 'fa fa-user',
        'name'       => 'users',
        'text'       => 'core::menu.users_title',
        'order'      => 7,
        'sub'        => [
            [
                'route'      => 'core.user.index',
                'permission' => [8,9,10,11],
                'class'      => '',
                'icon'       => 'fa fa-user',
                'name'       => 'users',
                'text'       => 'core::menu.users',
                'order'      => 1,
                'sub'        => []
            ],
            [
                'route'      => 'core.role.index',
                'permission' => [12,13,14,15],
                'class'      => '',
                'icon'       => 'fa fa-user',
                'name'       => 'roles',
                'text'       => 'core::menu.roles',
                'order'      => 2,
                'sub'        => []
            ],
            [
                'route'      => 'core.group.index',
                'permission' => [16,17,18,19],
                'class'      => '',
                'icon'       => 'fa fa-user',
                'name'       => 'groups',
                'text'       => 'core::menu.groups',
                'order'      => 3,
                'sub'        => []
            ]
        ]
    ],
    'dashboard' => [
        'route'      => 'core.dashboard',
        'permission' => [],
        'class'      => '',
        'icon'       => 'fa fa-dashboard',
        'name'       => 'dashboard',
        'text'       => 'core::menu.dashboard',
        'order'      => 1,
        'sub'        => []
    ],
];
