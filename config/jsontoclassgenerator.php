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
        'message' => [
            'author' => [
                'first_name' => '',
                'last_name'  => '',
            ],
            'text'   => '',
            'date'   => '2019-01-01'
        ]
    ],
    # Remember to define an object with a key name
    'json'          => "{}"
];