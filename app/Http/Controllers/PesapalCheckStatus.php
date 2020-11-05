<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OAUTHS\OAuthException;
use App\OAUTHS\OAuthConsumer;
use App\OAUTHS\OAuthToken;
use App\OAUTHS\OAuthSignatureMethod;
use App\OAUTHS\OAuthSignatureMethod_HMAC_SHA1;
use App\OAUTHS\OAuthSignatureMethod_PLAINTEXT;
use App\OAUTHS\OAuthSignatureMethod_RSA_SHA1;
use App\OAUTHS\OAuthRequest;
use App\OAUTHS\OAuthServer;
use App\OAUTHS\OAuthDataStore;
use App\OAUTHS\OAuthUtil;

class PesapalCheckStatus extends Controller
{
    public $token;
    public $params;
    public $signature_method;
    public $QueryPaymentStatus;
    public $QueryPaymentStatusByMerchantRef;
	public $querypaymentdetails;

    public function __construct()
    {
        $this->token = $this->params = NULL;
        $this->consumer_key = config('configuration.pesapal.key');
        $this->consumer_secret = config('configuration.pesapal.secret');
        $this->signature_method = new OAuthSignatureMethod_HMAC_SHA1();
        $this->consumer 		= new OAuthConsumer($this->consumer_key, $this->consumer_secret);
        $this->QueryPaymentStatus 				= 	'https://www.pesapal.com/API/QueryPaymentStatus';
		$this->QueryPaymentStatusByMerchantRef	= 	'https://www.pesapal.com/API/QueryPaymentStatusByMerchantRef';
		$this->querypaymentdetails 				= 	'https://www.pesapal.com/API/querypaymentdetails';

    }
    public function checkStatusByTrackingIdandMerchantRef($MerchantReference,$TrackingId)
    {
        $request_status = OAuthRequest::from_consumer_and_token(
								$this->consumer, 
								$this->token, 
								"GET", 
								$this->QueryPaymentStatus, 
								$this->params
							);
		$request_status->set_parameter("pesapal_merchant_reference", $MerchantReference);
		$request_status->set_parameter("pesapal_transaction_tracking_id",$TrackingId);
		$request_status->sign_request($this->signature_method, $this->consumer, $this->token);		
		$status = $this->curlRequest($request_status);
		return $status;
    }
    function getTransactionDetails($MerchantReference,$TrackingId)
    {
		$request_status = OAuthRequest::from_consumer_and_token(
								$this->consumer, 
								$this->token, 
								"GET", 
								$this->querypaymentdetails, 
								$this->params
							);
		$request_status->set_parameter("pesapal_merchant_reference", $MerchantReference);
		$request_status->set_parameter("pesapal_transaction_tracking_id",$TrackingId);
		$request_status->sign_request($this->signature_method, $this->consumer, $this->token);	
		$responseData = $this->curlRequest($request_status);		
		$pesapalResponse = explode(",", $responseData);
		$pesapalResponseArray=array('pesapal_transaction_tracking_id'=>$pesapalResponse[0],
				   'payment_method'=>$pesapalResponse[1],
				   'status'=>$pesapalResponse[2],
				   'pesapal_merchant_reference'=>$pesapalResponse[3]);				   
		return $pesapalResponseArray;
    }
    function checkStatusByMerchantRef($MerchantReference){	
		$request_status = OAuthRequest::from_consumer_and_token(
								$this->consumer, 
								$this->token, 
								"GET", 
								$this->QueryPaymentStatusByMerchantRef, 
								$this->params
							);
		$request_status->set_parameter("pesapal_merchant_reference", $MerchantReference);
		$request_status->sign_request($this->signature_method, $this->consumer, $this->token);	
		$status = $this->curlRequest($request_status);	
		return $status;
    }
    function curlRequest($request_status){		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $request_status);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		if(defined('CURL_PROXY_REQUIRED')) if (CURL_PROXY_REQUIRED == 'True'){
			$proxy_tunnel_flag = (
					defined('CURL_PROXY_TUNNEL_FLAG') 
					&& strtoupper(CURL_PROXY_TUNNEL_FLAG) == 'FALSE'
				) ? false : true;
			curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, $proxy_tunnel_flag);
			curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt ($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
		}		
		$response 					= curl_exec($ch);
		$header_size 				= curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$raw_header  				= substr($response, 0, $header_size - 4);
		$headerArray 				= explode("\r\n\r\n", $raw_header);
		$header 					= $headerArray[count($headerArray) - 1];		
		//transaction status
		$elements = preg_split("/=/",substr($response, $header_size));
		$response_data = $elements[1];		
		return $response_data;
	}
}