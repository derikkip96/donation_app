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
use App\Models\Transaction;
use App\Http\Controllers\PesapalCheckStatus;
use App\User;



class DonationController extends Controller
{    
    protected $token;
    protected $params;
    protected $consumer_key;
    protected $consumer_secret;
    protected $signature_method;
    protected $iframelink;

    public function __construct()
    {
        $this->token = NULL;
        $this->params = NULL;
        $this->consumer_key =config('configuration.pesapal.key');
        $this->consumer_secret = config('configuration.pesapal.secret');
        $this->signature_method   = new OAuthSignatureMethod_HMAC_SHA1();
        $this->iframelink = config('configuration.pesapal.iframe_link');
    }
   
    public function iframePay(Request $request)
    {
        $data= $request->all();
    
        $consumer 			= new OAuthConsumer($this->consumer_key,$this->consumer_secret);
        $ref				=  str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5);

        $data['reference']	=  substr(str_shuffle($ref),0,10);
        $amount 		= number_format($data['amount'], 2); 
        $desc 			= $data['description'];
        $type 			= 'MERCHANT';	
        $first_name 	= $data['first_name'];
        $last_name 		= $data['last_name'];
        $email 			= $data['email'];
        $phonenumber	= $data['phone_number'];
        $currency 		= $data['currency'];
        $reference 		= $data['reference'];
        $callback_url = url('/payment-complete');

        $user_data = User::create([
            'first_name'=>	$data['first_name'],
			'last_name'	=>	$data['last_name'],
			'email'		=>	$data['email'],
			'phone'	    =>	$data['phone_number'],
        ]);

        $transaction = Transaction::create([
            'currency'	=>	$data['currency'],
            'amount'	=>	$data['amount'],
            'status'	=>	'PLACED', 
            'reference'	=>	$data['reference'],
            'userId' 	=>$user_data->id 	
        ]);

        $post_xml	= "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				        <PesapalDirectOrderInfo 
						xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" 
					  	xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" 
					  	Currency=\"".$currency."\" 
					  	Amount=\"".$amount."\" 
					  	Description=\"".$desc."\" 
					  	Type=\"".$type."\" 
					  	Reference=\"".$reference."\" 
					  	FirstName=\"".$first_name."\" 
					  	LastName=\"".$last_name."\" 
					  	Email=\"".$email."\" 
					  	PhoneNumber=\"".$phonenumber."\" 
					  	xmlns=\"http://www.pesapal.com\" />";
        $post_xml = htmlentities($post_xml);
        
        $iframe_src = OAuthRequest::from_consumer_and_token($consumer, $this->token, "GET", $this->iframelink, $this->params);
        $iframe_src->set_parameter("oauth_callback", $callback_url);
        $iframe_src->set_parameter("pesapal_request_data", $post_xml);
        $iframe_src->sign_request($this->signature_method, $consumer, $this->token);

        return view('pay',compact('iframe_src'));
	
    }
    public function donorForm()
    {
        return view('donorform');
    }
    public function responsePage(Request $request)
    {
        $MerchantReference	= null;
        $TrackingId 		= null;
        $checkStatus 		= new PesapalCheckStatus();
        if($request->has('pesapal_merchant_reference') )
        {
            $MerchantReference = $request->get('pesapal_merchant_reference');
        }
        if($request->has('pesapal_transaction_tracking_id')){
            $TrackingId = $request->get('pesapal_transaction_tracking_id');
        }
        $status =  $checkStatus->checkStatusByTrackingIdandMerchantRef($MerchantReference,$TrackingId);

        return view('redirect_page',compact('status','MerchantReference','TrackingId'));
    }
    public function donorFormPage(Request $request){
        return view('donorform');
    }
}
