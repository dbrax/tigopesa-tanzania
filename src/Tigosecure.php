<?php

namespace Epmnzava\Tigosecure;

class Tigosecure
{
    // Build your next great package.


    public  string $base_url,$issuedToken,$customer_firstname,$customer_lastname,$customer_email,$amount,$refecence_id;


    public function access_token(){

       $api=new TigoUtil();

       $tokenArray=json_decode($api->get_access_token(config('tigosecure.api_url')));
       $this->issuedToken=$tokenArray->accessToken;

    }

    public function make_payment($customer_firstname,$customer_lastname,$customer_email,$amount,$refecence_id){

        $this->access_token();
        $api=new TigoUtil();
        $base_url=config('tigosecure.api_url');
       $response=$api->makePaymentRequest($base_url,$this->issuedToken,$amount,$refecence_id,$customer_firstname,$customer_lastname,$customer_email);
        
       $array_response=json_decode($response);
     
       return $array_response;
    }

    /**
     * @param string $prefix
     * @param int $length
     *
     * @return string
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
