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
        # so each array needs to be defined with a key name, for example, 'post' is a key name
        'post'     => (object)[
            'author'    => (object)[
                'id'         => 1,
                'note'       => null,
                'rating'     => 4.6,
                'first_name' => '',
                'last_name'  => '',
            ],
            'comment'   => (object)[
                'comment_by' => (object)[
                    'is_active'  => false,
                    'first_name' => '',
                    'last_name'  => ''
                ],
                'content'    => ''
            ],
            'followers' => (object)[
                'id'             => 1,
                'follower_users' => (array)[
                    'first_name' => '',
                    'last_name'  => ''
                ]
            ],
            'views'     => 123,
            'text'      => '',
            'date'      => '2019-01-01'
        ],
        'feedback' => (object)[
            'comment' => ''
        ]
    ],
];
