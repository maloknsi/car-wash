<?php
return [
    'p_admin' => [
        'type' => 2,
        'description' => 'Админка',
    ],
    'p_operator' => [
        'type' => 2,
        'description' => 'Операторская',
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
            'p_operator',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Админ',
        'ruleName' => 'userRole',
        'children' => [
            'p_admin',
            'operator',
        ],
    ],
];
