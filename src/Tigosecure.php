<?php

/**
 * Author: Emmanuel Paul Mnzava
 * Twitter: @epmnzava
 * Github:https://github.com/dbrax/tigopesa-tanzania
 * Email: epmnzava@gmail.com
 * 
 */

namespace Epmnzava\Tigosecure;

class Tigosecure
{


    public string $base_url, $issuedToken, $customer_firstname, $customer_lastname, $customer_email, $amount, $reference_id;

    /**
     *  access_token
     */
    public function access_token()
    {

        $api = new TigoUtil();

        $tokenArray = json_decode($api->get_access_token(config('tigosecure.api_url')));
        $this->issuedToken = $tokenArray->accessToken;

        $tokenArray = json_decode($api->get_access_token(config('tigosecure.api_url')));
        $this->issuedToken = $tokenArray->accessToken;
    }

    /**
     * make_payment
     *
     * @param $customer_firstname
     * @param $customer_lastname
     * @param $customer_email
     * @param $amount
     * @param $reference_id
     * @return mixed
     */
    public function make_payment($customer_firstname, $customer_lastname, $customer_email, $amount, $reference_id)
    {

        $this->access_token();
        $api = new TigoUtil();
        $base_url = config('tigosecure.api_url');
        $response = $api->makePaymentRequest($base_url, $this->issuedToken, $amount, $reference_id, $customer_firstname, $customer_lastname, $customer_email);

        return json_decode($response);
    }

    /**
     * @param string $prefix
     * @param int $length
     *
     * @return string
     * @throws \Exception
     */
    public function random_reference($prefix = 'PESAPAL', $length = 15)
    {
        $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $str = '';

        $max = mb_strlen($keyspace, '8bit') - 1;

        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }

        return $prefix . $str;
    }
}
