<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['groups' => 'api/groups'],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['users' => 'api/users'],
        'extraPatterns' => [
            'PATCH <id>/assign-to-group' => 'assign-to-group',
    	]
    ]
];