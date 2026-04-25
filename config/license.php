<?php

return [
    /*
    |--------------------------------------------------------------------------
    | License Server Configuration
    |--------------------------------------------------------------------------
    */
    'server_url' => env('LICENSE_SERVER_URL', 'https://3bdulrahman.com'),
    'product_code' => env('LICENSE_PRODUCT_CODE', 'PRFL-001'),

    /*
    |--------------------------------------------------------------------------
    | Public Key for Verification
    |--------------------------------------------------------------------------
    |
    | This public key is used to verify the signed response from the authority.
    | It corresponds to the private key stored on the server.
    |
    */
    'public_key' => "-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3iooRkEV6OK9rPCVYMck\n2fJfsg2oorCcpVot3lA4JHt458KdUYP84mVCZMwB41lwe3OXBn6JORp0wdlVSFB0\n2zMguoIj2BAJkrIM/SIYa/KLOyFtsiv3661f8QusBmBHs/vsb7ZO9fpAyfyaYWZD\npCS8ZyK79cnXTduHI/u6xdADDmC895Q4dFxFpwedGGowyXP7HdnMWmBVCcf5mq66\nF82s7EmugWcI/HWOc68piOwfNWmPZ032+XzNox1cbkvVSdDbiwVkV6YvHc8tVj85\nzlbT+JfhmgtD3ipL1wQ2dCgzkzWXHGdLgPpTQZiaJqigXNoWWpXVdEtHi3EZdEE3\npQIDAQAB\n-----END PUBLIC KEY-----",

    /*
    |--------------------------------------------------------------------------
    | Cache & Check Settings
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 hour for local DB cache
    ],

    // How often to call the server to verify (in hours)
    'check_frequency' => 24,

    // How many days to allow usage if the server is unreachable
    'local_grace_period_days' => 7,

    'timeout' => 10,
];

