<?php

return [

    /*
    * Tigosecure Client id
    */

    'client_id' => env("TIGO_CLIENT_ID"),

    /*
     * Tigosecure  consumer secret
     */
    'secret' => env("TIGO_CLIENT_SECRET"),

    /*
     * Tigosecure  api  url
     */
    'api_url' => env("TIGO_API_URL"),

    /*
     * Tigosecure pin
     */
    'pin' => env("TIGO_PIN"),

    /*
     * Tigosecure  account number
     */
    'account_number' => env("TIGO_ACCOUNT_NUMBER"),

    /*
     * Tigo secure  account id
     */
    'account_id' => env("TIGO_ACCOUNT_ID"),


    /*
     * Your  application url
     */
    'app_url' => env('APP_URL_LINK'),

    /*
     * Your  application  redirect url
     */
    'redirect_url' => env('TIGO_REDIRECT'),


    /*
     * Your  application  callback url
     */
    'callback_url' => env('TIGO_CALLBACK'),


    /*
     * Your  application currency code ( TZS ) for Tanzania
     */
    'currency_code' => env('APP_CURRENCY_CODE'),


    /*
     * Your  application language code en for english sw for swahili
     */
    'lang' => env('LANG')


];


