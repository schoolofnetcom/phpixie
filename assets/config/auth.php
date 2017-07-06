<?php

return [
    'domains' => [
        'default' => [
            'repository' => 'framework.orm.user',
            'providers'  => [
                'session' => [
                    'type' => 'http.session'
                ],
                'password' => [
                    'type' => 'login.password',
                    'persistProviders' => ['session']
                ]
            ]
        ]
    ]
];