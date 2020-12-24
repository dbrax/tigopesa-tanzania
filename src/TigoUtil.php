<?php

namespace Epmnzava\Tigosecure;


use Illuminate\Support\Facades\Log;

/**
 * TigoUtil
 * @version 1.*
 * @author Emmanuel Paul Mnzava
 * @author Twitter: @epmnzava
 * @author Email: epmnzava@gmail.com
 */
class TigoUtil
{
    const AUTH_URL = "/v1/oauth/generate/accesstoken?grant_type=client_credentials";

    /**
     * @param string $base_url
     * @return bool|string
     */
    public function get_access_token(string $base_url)
    {

        $access_token_url = $base_url . self::AUTH_URL;

        $data = [
            'client_id' => config('tigosecure.client_id'),
            'client_secret' => config('tigosecure.secret')
        ];

        $ch = curl_init($access_token_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_URL, $access_token_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


    /**
     * @param $amount
     * @param $reference_id
     * @param $customer_firstname
     * @param $customer_lastname
     * @param $customer_email
     * @return string
     */
    public function createPaymentAuthJson($amount, string $reference_id, string $customer_firstname, string $customer_lastname, string $customer_email): string
    {


        $paymentJson = '{
  "MasterMerchant": {
    "account": "' . config('tigosecure.account_number') . '",
    "pin": "' . config('tigosecure.pin') . '",
    "id": "' . config('tigosecure.account_id') . '"
  },
  "Merchant": {
    "reference": "",
    "fee": "0.00",
    "currencyCode": ""
  },
  "Subscriber": {
    "account": "",
    "countryCode": "255",
    "country": "TZA",
    "firstName": "' . $customer_firstname . '",
    "lastName": "' . $customer_lastname . '",
    "emailId": "' . $customer_email . '"
  },
  "redirectUri":" ' . config('tigosecure.redirect_url') . '",
  "callbackUri": "' . config('tigosecure.callback_url') . '",
  "language": "' . config('tigosecure.lang') . '",
  "terminalId": "",
  "originPayment": {
    "amount": "300.00",
    "currencyCode": "' . config('tigosecure.currency_code') . '",
    "tax": "0.00",
    "fee": "0.00"
  },
  "exchangeRate": "1",
  "LocalPayment": {
    "amount": "300.00",
    "currencyCode": "' . config('tigosecure.currency_code') . '"
  },
  "transactionRefId": "' . $reference_id . '"
}';

        return $paymentJson;

    }


    /**
     * @param string $base_url
     * @param string $issuedToken
     * @param string $amount
     * @param string $reference_id
     * @param string $customer_firstname
     * @param string $customer_lastname
     * @param string $customer_email
     * @return bool|string
     */
    public function makePaymentRequest(string $base_url, string $issuedToken, string $amount, string $reference_id, string $customer_firstname, string $customer_lastname, string $customer_email)
    {

        $access_token_url = $base_url . "/v1/tigo/payment-auth/authorize";

        $paymentAuthUrl = $access_token_url;
        $ch = curl_init($paymentAuthUrl);
        curl_setopt_array($ch, array(
            CURLOPT_URL => $paymentAuthUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this->createPaymentAuthJson($amount, $reference_id, $customer_firstname, $customer_lastname, $customer_email),
            CURLOPT_HTTPHEADER => array(
                "accesstoken:" . $issuedToken,
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}
