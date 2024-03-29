<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],
        
        'monolog' => [
            'driver' => 'monolog',
            'handler' => Monolog\Handler\StreamHandler::class,
            'with' => [
                'stream' => storage_path('logs/monolog.log'),
            ],
        ],
        

        'create_task' => [
            'driver' => 'single',
            'path' => storage_path('logs/create_task.log'),
            'level' => 'info',
        ],
        
        'create_deal' => [
            'driver' => 'single',
            'path' => storage_path('logs/create_deal.log'),
            'level' => 'info',
        ],

        'create_leads' => [
            'driver' => 'single',
            'path' => storage_path('logs/create_leads.log'),
            'level' => 'info',
        ],

        'update_leads' => [
            'driver' =>'single',
            'path' => storage_path('logs/update_leads.log'),
            'level' => 'info',
            'bubble' => true,
        ],

        'update_task' => [
            'driver' =>'single',
            'path' => storage_path('logs/update_task.log'),
            'level' => 'info',
            'bubble' => true,
        ],

        'add_product' => [
            'driver' =>'single',
            'path' => storage_path('logs/add_product.log'),
            'level' => 'info',
            'bubble' => true,
        ],

        'update_product' => [
            'driver' =>'single',
            'path' => storage_path('logs/update_product.log'),
            'level' => 'info',
            'bubble' => true,
        ],

        'deleted_product' => [
            'driver' =>'single',
            'path' => storage_path('logs/deleted_product.log'),
            'level' => 'info',
            'bubble' => true,
        ],

        'create_company' => [
            'driver' => 'single',
            'path' => storage_path('logs/ create_company.log'),
            'level' => 'info',
        ],

        'create_account' => [
            'driver' => 'single',
            'path' => storage_path('logs/ create_account.log'),
            'level' => 'info',
        ],

        'create_meeting' => [
            'driver' => 'single',
            'path' => storage_path('logs/ create_meeting.log'),
            'level' => 'info',
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],

];
