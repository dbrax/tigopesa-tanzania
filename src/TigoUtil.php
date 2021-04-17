<?php

/**
 * Author: Emmanuel Paul Mnzava
 * Twitter: @epmnzava
 * Email: epmnzava@gmail.com
 * Github:https://github.com/dbrax/tigopesa-tanzania
 * This class contains all api calls ..
 */

namespace Epmnzava\Tigosecure;

use Epmnzava\Tigosecure\Configs\V1\TigoConfigs;
use Exception;
use GuzzleHttp\Client;
use Log;
use Throwable;

class TigoUtil extends TigoConfigs
{


  private $client_id;
  private $client_secret;
  private $base_url;

  public function __construct($client_id, $client_secret, $base_url)
  {

    $this->client_id = $client_id;
    $this->client_secret = $client_secret;
    $this->base_url = $base_url;
  }



  /**
   * @param $amount
   * @param $refersence_id
   * @param $customer_firstname
   * @param $custormer_lastname
   * @param $customer_email
   * @return string
   *
   * function that creates payment authentication json
   */

  public function createPaymentAuthJson(
    $amount,
    $refecence_id,
    $customer_firstname,
    $custormer_lastname,
    $customer_email
  ): string {


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
    "amount": "' . $amount . '",
    "currencyCode": "' . config('tigosecure.currency_code') . '",
    "tax": "0.00",
    "fee": "0.00"
  },
  "exchangeRate": "1",
  "LocalPayment": {
    "amount": "' . $amount . '",
    "currencyCode": "' . config('tigosecure.currency_code') . '"
  },
  "transactionRefId": "' . $refecence_id . '"
}';




    return $paymentJson;
  }


  /**
   * Using Curl Request
   * @param string $base_url
   * @param $issuedToken
   * @param $amount
   * @param $refecence_id
   * @param $customer_firstname
   * @param $custormer_lastname
   * @param $customer_email
   * @return bool|string
   *
   */

  public function makePaymentRequest($issuedToken, $amount, $refecence_id, $customer_firstname, $custormer_lastname, $customer_email)
  {

    $paymentAuthUrl = $this->base_url . self::PAYMENT_AUTHORIZATION_ENDPOINT;
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

    curl_close($ch);

    return $response;
  }

  public function get_access_token()
  {
    $access_token_url = $this->base_url . self::ACCESS_TOKEN_ENDPOINT;

    $data = [
      'client_id' => config('tigosecure.client_id'),
      'client_secret' => config('tigosecure.secret')
    ];
//Will have to add try catch
    //try{
  //}
   // catch(Throwable $e){
 //     report($e);
 //     return json_encode(["message"=>"Error Found ".$e,"status"=>500]);
 //   }

    $client = new  Client;
    $response = $client->request('POST', $access_token_url, [
      'form_params' => $data
    ]);
    return $response->getBody();

        
  }


}
