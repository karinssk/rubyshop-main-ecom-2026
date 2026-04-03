<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'line' => [
        'client_id' => env('LINE_CLIENT_ID'),
        'client_secret' => env('LINE_CLIENT_SECRET'),
        'redirect' => env('LINE_REDIRECT_URI'),
        'notification_channel_secret' => env('LINE_CHANNEL_CECRET_FOR_NOTIFY'),
        'notification_channel_access_token' => env(
            'LINE_CHANNEL_ACCESS_TOKEN__FOR_NOTIFY',
            env('LINE_MESSAGING_CHANNEL_ACCESS_TOKEN')
        ),
        'notification_to' => env(
            'LINE_USER_ID_FOR_SENDING_MESSAGE',
            env('LINE_MESSAGING_TO')
        ),
        'messaging_channel_access_token' => env('LINE_MESSAGING_CHANNEL_ACCESS_TOKEN'),
        'messaging_to' => env('LINE_MESSAGING_TO'),
        'notify_token' => env('LINE_NOTIFY_TOKEN'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    ],

];
