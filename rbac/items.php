<?php
return [
    'dashboard' => [
        'type' => 2,
        'description' => 'Админ панель',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
        'ruleName' => 'userRole',
    ],
    'operator' => [
        'type' => 1,
        'description' => 'Оператор',
        'ruleName' => 'userRole',
        'children' => [
            'user',
            'dashboard',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Админ',
        'ruleName' => 'userRole',
        'children' => [
            'operator',
        ],
    ],
];
