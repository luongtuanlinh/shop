<?php

return [
    'users' => [
        'route'      => 'core.user.index',
        'permission' => [],
        'class'      => '',
        'icon'       => 'fa fa-user',
        'name'       => 'users',
        'text'       => 'core::menu.users_title',
        'order'      => 7,
        'sub'        => [
            [
                'route'      => 'core.user.create',
                'permission' => [],
                'class'      => '',
                'icon'       => 'fa fa-user',
                'name'       => 'users',
                'text'       => 'core::menu.users',
                'order'      => 1,
                'sub'        => []
            ],
            [
                'route'      => 'core.role.index',
                'permission' => [],
                'class'      => '',
                'icon'       => 'fa fa-user',
                'name'       => 'roles',
                'text'       => 'core::menu.roles',
                'order'      => 2,
                'sub'        => []
            ],
            [
                'route'      => 'core.group.index',
                'permission' => [],
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
