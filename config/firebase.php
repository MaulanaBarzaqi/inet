<?php

declare(strict_types=1);

return [
    /*
     * ------------------------------------------------------------------------
     * Default Firebase project
     * ------------------------------------------------------------------------
     */

    'default' => env('FIREBASE_PROJECT', 'app'),

    /*
     * ------------------------------------------------------------------------
     * Firebase project configurations
     * ------------------------------------------------------------------------
     */

    'projects' => [
        'app' => [

            /*
             * ------------------------------------------------------------------------
             * Credentials / Service Account
             * ------------------------------------------------------------------------
             *
             * In order to access a Firebase project and its related services using a
             * server SDK, requests must be authenticated. For server-to-server
             * communication this is done with a Service Account.
             *
             * If you don't already have generated a Service Account, you can do so by
             * following the instructions from the official documentation pages at
             *
             * https://firebase.google.com/docs/admin/setup#initialize_the_sdk
             *
             * Once you have downloaded the Service Account JSON file, you can use it
             * to configure the package.
             *
             * If you don't provide credentials, the Firebase Admin SDK will try to
             * auto-discover them
             *
             * - by checking the environment variable FIREBASE_CREDENTIALS
             * - by checking the environment variable GOOGLE_APPLICATION_CREDENTIALS
             * - by trying to find Google's well known file
             * - by checking if the application is running on GCE/GCP
             *
             * If no credentials file can be found, an exception will be thrown the
             * first time you try to access a component of the Firebase Admin SDK.
             *
             */

            // 'credentials' => env('FIREBASE_CREDENTIALS', env('GOOGLE_APPLICATION_CREDENTIALS')),
            'credentials' => [
                "type" => "service_account",
                "project_id" => "inet-bf940",
                "private_key_id"=> "13eab496d65df597c5c504c16733f5c19385d668",
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCkCaj30JHONH7j\nJDTF3WVzVwXkNng7yoGgZkA6kRgiX4pmp/GvtkkWpdYmCxe5Fky2zGfUACShmr17\n3IRQ09MWVozhLPPU0Z96xsF881AvkIHtgsMqNzsF2Kr8JAG/Sh80lHqgJELA7DLJ\ncm+PYRaQWFbH1OK31FfhqB9nFf6OOrHbrtY+Iy4A7on6c2E863bFhmiJj1hSkvjJ\noZjqEeF5p56lxFV1f/QJKB9LbAv70s2FyprDxtj3xMezf2Vd71P/Bi/9JXltQGOj\n/glMydLeSnsW8iTFDJekxaIgFOMHkXXu7lGsWuhFd98Rn27R4QMkfbOrjWC0qZ34\nAKlpl9GvAgMBAAECggEABWTFsqIRrM8soVkeTqer2ErPj3KKKfmS2gHCsY3Zj00c\neIz5H9/wE0lzwkMjjhsWtqeN78F5ct7cxXUratMsNzeX/WBSkXgs0SOL5SVvZU8z\nwSLVj4dY7pcrOBpLbjDBgs4xsDukjHrwneTZJqgxeYQ4vyVXtxCQkIOTVMH0KI3l\nttMBk5aGbTf7UGKLobA7qdwISacLa5XaxmlPH+TGOj1tf2rTZsauljl2jSVkt0pN\nD6reiK2jOmk4xGvPYZcKIy03AvpwflnHKagBMZ4DPQJT4ceQyJfJyXxPGuLJsYNk\nA84wosteKBhgs7kFIuwobhAxXsUAdxmuQZxLwbzggQKBgQDnN71aeXyzyfDTSnxB\ncgJ2Ee6NLPgW5Tv2E/ZX7qKv0xQt4CPUgg+qVdQ/rTpwr49I4b6m7ZygNvXClIC1\n69ZOw8aTVK4wprIJxv8r+dgimTGzE0m80zPHgk3Kx+tCzYuZKCLtUpctAEwsKGK8\nt0SjyYpLS6+y0C4wdjN5Ak09jwKBgQC1npqoyeRN5LTx6WAdXMkph/2BZtxLwPtV\nalcKWY/jmP6aQF/ikoO9ud5vB3TxXA/kFIuE9TeeGL8DgBP187KfAvzuBqxbqcz6\nBQLbBPKJjUXfQodkXKVXQalS3BG+jQBE1b0prb4FkhAfMQ0t7SehOSNCRUox08Dv\nnF+ZVtJZ4QKBgQDMEcQLwEGxpL/qnEkCsg8+CiGTdGcaPgQn8gJwJWxs5k1fF/5H\npusQmWQVN1zm6+v4lVVhm0GrnhZWQB9BcP7a0avHiOucgOOOAZZhR8fc8XyN4q4n\n+/gtU/I40S3w7d0RtfztnQFUdHjGWHacvNvV+yEVx50wotDBcPGJEeD+PQKBgFJG\nlHesZkGnPxVsDL+gffzTf1M0vs2Okg1CzEWDBz0q3QQR754bk5TKc+rGbQK+GvDP\nIdlMoTJ8sWOrjN9Z0+xXFS/bVA9+X75PsNh5aEpJ9oJKiD09/yUFOOixi1RQWfPV\nBAmyjKfHYIhQ11Cb490UnlVyQEdMT1X8+A3mGArhAoGATGEO78Ye39hgDqtrXRlH\nhBJC4x+iDJtnxHSQV/AGwUphoLD98+Z3/oLLIL9IU04LwtcefKK+S7DYZ98CyJf9\n6DiYYGQhx2bs8uizTrEdu2nDgYkrrUEV7xGP8/QEc/d45xopuJ+LmFqEGwsbldgo\n0N8uxY3XgCFMg4zxDkH8PAI=\n-----END PRIVATE KEY-----\n",
                "client_email" => "firebase-adminsdk-fbsvc@inet-bf940.iam.gserviceaccount.com",
                "client_id" => "108186422154099127078",
                "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                "token_uri"=> "https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-fbsvc%40inet-bf940.iam.gserviceaccount.com",
                "universe_domain" => "googleapis.com"
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Auth Component
             * ------------------------------------------------------------------------
             */

            'auth' => [
                'tenant_id' => env('FIREBASE_AUTH_TENANT_ID'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firestore Component
             * ------------------------------------------------------------------------
             */

            'firestore' => [

                /*
                 * If you want to access a Firestore database other than the default database,
                 * enter its name here.
                 *
                 * By default, the Firestore client will connect to the `(default)` database.
                 *
                 * https://firebase.google.com/docs/firestore/manage-databases
                 */

                // 'database' => env('FIREBASE_FIRESTORE_DATABASE'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Realtime Database
             * ------------------------------------------------------------------------
             */

            'database' => [

                /*
                 * In most of the cases the project ID defined in the credentials file
                 * determines the URL of your project's Realtime Database. If the
                 * connection to the Realtime Database fails, you can override
                 * its URL with the value you see at
                 *
                 * https://console.firebase.google.com/u/1/project/_/database
                 *
                 * Please make sure that you use a full URL like, for example,
                 * https://my-project-id.firebaseio.com
                 */

                'url' => env('FIREBASE_DATABASE_URL'),

                /*
                 * As a best practice, a service should have access to only the resources it needs.
                 * To get more fine-grained control over the resources a Firebase app instance can access,
                 * use a unique identifier in your Security Rules to represent your service.
                 *
                 * https://firebase.google.com/docs/database/admin/start#authenticate-with-limited-privileges
                 */

                // 'auth_variable_override' => [
                //     'uid' => 'my-service-worker'
                // ],

            ],

            'dynamic_links' => [

                /*
                 * Dynamic links can be built with any URL prefix registered on
                 *
                 * https://console.firebase.google.com/u/1/project/_/durablelinks/links/
                 *
                 * You can define one of those domains as the default for new Dynamic
                 * Links created within your project.
                 *
                 * The value must be a valid domain, for example,
                 * https://example.page.link
                 */

                'default_domain' => env('FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN'),
            ],

            /*
             * ------------------------------------------------------------------------
             * Firebase Cloud Storage
             * ------------------------------------------------------------------------
             */

            'storage' => [

                /*
                 * Your project's default storage bucket usually uses the project ID
                 * as its name. If you have multiple storage buckets and want to
                 * use another one as the default for your application, you can
                 * override it here.
                 */

                'default_bucket' => env('FIREBASE_STORAGE_DEFAULT_BUCKET'),

            ],

            /*
             * ------------------------------------------------------------------------
             * Caching
             * ------------------------------------------------------------------------
             *
             * The Firebase Admin SDK can cache some data returned from the Firebase
             * API, for example Google's public keys used to verify ID tokens.
             *
             */

            'cache_store' => env('FIREBASE_CACHE_STORE', 'file'),

            /*
             * ------------------------------------------------------------------------
             * Logging
             * ------------------------------------------------------------------------
             *
             * Enable logging of HTTP interaction for insights and/or debugging.
             *
             * Log channels are defined in config/logging.php
             *
             * Successful HTTP messages are logged with the log level 'info'.
             * Failed HTTP messages are logged with the log level 'notice'.
             *
             * Note: Using the same channel for simple and debug logs will result in
             * two entries per request and response.
             */

            'logging' => [
                'http_log_channel' => env('FIREBASE_HTTP_LOG_CHANNEL'),
                'http_debug_log_channel' => env('FIREBASE_HTTP_DEBUG_LOG_CHANNEL'),
            ],

            /*
             * ------------------------------------------------------------------------
             * HTTP Client Options
             * ------------------------------------------------------------------------
             *
             * Behavior of the HTTP Client performing the API requests
             */

            'http_client_options' => [

                /*
                 * Use a proxy that all API requests should be passed through.
                 * (default: none)
                 */

                'proxy' => env('FIREBASE_HTTP_CLIENT_PROXY'),

                /*
                 * Set the maximum amount of seconds (float) that can pass before
                 * a request is considered timed out
                 *
                 * The default time out can be reviewed at
                 * https://github.com/kreait/firebase-php/blob/6.x/src/Firebase/Http/HttpClientOptions.php
                 */

                'timeout' => env('FIREBASE_HTTP_CLIENT_TIMEOUT'),

                'guzzle_middlewares' => [
                    // MyInvokableMiddleware::class,
                    // [MyMiddleware::class, 'static_method'],
                ],
            ],
        ],
    ],
];
