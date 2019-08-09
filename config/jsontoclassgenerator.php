<?php

return [
    // namespace
    'namespace'     => 'App\Test',
    // default file store location
    'file_location' => app_path(),
    // this tells the generator which original source format that will be used for translation.
    'driver'        => 'array',
    'array'         => [
        # Please define an object instead of item
        # so each array needs to be defined with a key name, for example, 'message' is a key name
        'post' => [
            'author'    => (object)[
                'first_name' => '',
                'last_name'  => '',
            ],
            'comment'   => (object)[
                'user'    => (object)[
                    'first_name' => '',
                    'last_name'  => ''
                ],
                'content' => ''
            ],
            'followers' => (array)[
                'id'            => '',
                'follower_user' => [
                    'first_name' => '',
                    'last_name'  => ''
                ]
            ],
            'text'      => '',
            'date'      => '2019-01-01'
        ]
    ],
];
