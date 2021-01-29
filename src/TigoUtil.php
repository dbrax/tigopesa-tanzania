<?php

/**
 * Author: Emmanuel Paul Mnzava
 * Twitter: @epmnzava
 * Email: epmnzava@gmail.com
 * Github:https://github.com/dbrax/tigopesa-tanzania
 * This class contains all api calls ..
 */

namespace Epmnzava\Tigosecure;

use Log;

class TigoUtil
{
  // Build your next great package.




  public   function get_access_token(string $base_url)
  {

    $access_token_url = $base_url . "/v1/oauth/generate/accesstoken?grant_type=client_credentials";

    $data = [
      'client_id' => config('tigosecure.client_id'),
      'client_secret' => config('tigosecure.secret')
    ];




    $ch = curl_init($access_token_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($ch, CURLOPT_URL, $access_token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    //    Log::info('TigoUtil::getAccessToken request='.$ch);
    $response = curl_exec($ch);

    Log::info('TigoUtil::get_access_token Token=' . $response);

    //$info = curl_getinfo($ch);
    //  $http_result = $info ['http_code'];
    curl_close($ch);

    return $response;
  }





  public function createPaymentAuthJson($amount, $refecence_id, $customer_firstname, $custormer_lastname, $customer_email)
  {

    //$transaction_number=transaction::where('id','>',1)->count();

    //$transaction_id="SIFA".$transaction_number.md5(date('d/m/y'));

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
    "lastName": "' . $custormer_lastname . '",
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
  "transactionRefId": "' . $refecence_id . '"
}';

    return $paymentJson;


    Log::info('TigoUtil::createPaymentAuthJson Token=' . $paymentJson);

    return $paymentJson;
  }



  public function makePaymentRequest(string $base_url, $issuedToken, $amount, $refecence_id, $customer_firstname, $custormer_lastname, $customer_email)
  {

    $access_token_url = $base_url . "/v1/tigo/payment-auth/authorize";

    //update transaction table about this transaction..
    Log::info('TigoUtil::makePaymentRequest Token');

    $paymentAuthUrl =  $access_token_url;
    $ch = curl_init($paymentAuthUrl);
    curl_setopt_array($ch, array(
      CURLOPT_URL => $paymentAuthUrl,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $this->createPaymentAuthJson($amount, $refecence_id, $customer_firstname, $custormer_lastname, $customer_email),
      CURLOPT_HTTPHEADER => array(
        "accesstoken:" . $issuedToken,
        "cache-control: no-cache",
        "content-type: application/json",
      ),
    ));

    $response = curl_exec($ch);
    //$info = curl_getinfo($ch);
    //  $http_result = $info ['http_code'];
    curl_close($ch);
    Log::info('TigoUtil::makePaymentRequest response=' . $response);

    return $response;
  }
}
