<?php

/**
 * Midtrans configuration
 *
 * This file contains the configuration for Midtrans.
 *
 * @see https://midtrans.com/docs/api
 */
return [
    /**
     * The server key is used to authenticate the request to Midtrans.
     *
     * @var string
     */
    'server_key' => env('MIDTRANS_SERVER_KEY', 'your-server-key-here'),

    /**
     * The client key is used to authenticate the request to Midtrans.
     *
     * @var string
     */
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'your-client-key-here'),

    /**
     * Whether this is a production environment or not.
     *
     * @var bool
     */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /**
     * Whether the transaction data should be sanitized or not.
     *
     * @var bool
     */
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    /**
     * Whether the transaction data should be sanitized according to the 3DS
     * specification or not.
     *
     * @var bool
     */
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];

?>
