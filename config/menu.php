<?php

return [
    // Each item: title, route (named route or url), icon (font-awesome class), can => optional permission
    [
        'title' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'fa fa-tachometer',
    ],
    [
        'title' => 'Users',
        'route' => 'users.index',
        'icon' => 'fa fa-users',
        'children' => [
            [
                'title' => 'All Users',
                'route' => 'users.index',
                'icon' => 'fa fa-list',
            ],
            [
                'title' => 'Create User',
                'route' => 'users.index',
                'icon' => 'fa fa-user-plus',
            ],
        ],
    ],
    [
        'title' => 'Settings',
        'route' => '#',
        'icon' => 'fa fa-cog',
    ],
];
