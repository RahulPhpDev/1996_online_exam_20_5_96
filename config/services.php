<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

      // 'google' => [
      //       'client_id' => '646543786541-uav218n8mocefkjobc1lqudbmr21ll7e.apps.googleusercontent.com',
      //       'client_secret' => '_mWwq29guz1iD23bVhoDWbXL',
      //       'redirect' => 'http://127.0.0.1:8000/login/google/callback'
      //   ],

     'google' => [
            'client_id' => env('google_client_id'),
            'client_secret' => env('google_client_secret'),
            'redirect' => env('google_redirect'),
        ],

        'facebook' => [
                    'client_id' => env('facebook_client_id'),
                    'client_secret' => env('facebook_client_secret'),
                    'redirect' => env('facebook_redirect'),
                ],

        // 'facebook' => [
        //             'client_id' => '1972474266412796',
        //             'client_secret' => '090100c5d4bfa39eef084d67cc62cc4f',
        //             'redirect' => 'http://127.0.0.1:8000/login/facebook/callback'
        //         ],

];
