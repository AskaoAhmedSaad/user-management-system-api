<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['groups' => 'api/groups'],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['users' => 'api/users'],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['xusergroup' => 'api/x-user-group'],
        'extraPatterns' => [
            'DELETE remove-from-group' => 'remove-from-group'
        ]
    ]
];