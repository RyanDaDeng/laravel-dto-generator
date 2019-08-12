<?php

return [
    // namespace
    'namespace'     => 'App',
    // default file store location
    'file_location' => app_path(),
    // this tells the generator which original source format that will be used for translation.
    'driver'        => 'array',
    'array'         => [
        # Please define an object instead of item
        # so each array needs to be defined with a key name, for example, 'message' is a key name
        'post' => [
            'author'   => (object)[
                'id'         => 1,
                'note'       => null,
                'rating'     => 4.6,
                'first_name' => '',
                'last_name'  => '',
            ],
            'comment'  => (object)[
                'user'    => (object)[
                    'is_active'  => false,
                    'first_name' => '',
                    'last_name'  => ''
                ],
                'content' => ''
            ],
            'followers' => (array)[
                'id'             => 1,
                'follower_users' => [
                    'first_name' => '',
                    'last_name'  => ''
                ]
            ],
            'views'    => 123,
            'text'     => '',
            'date'     => '2019-01-01'
        ]
    ],
];
