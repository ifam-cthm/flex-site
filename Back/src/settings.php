<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Database connection settings
        //     "db" => [
        //         "host" => "localhost",
        //         "dbname" => "flex_ged",
        //         "user" => "sa",
        //         "pass" => "cthm@flex2019"
        //     ],
        // ],
        "db" => [
            "host" => "localhost",
            "dbname" => "flex_ged",
            "user" => "sa",
            "pass" => "cthm@flex2019"
        ],
    ],
];
