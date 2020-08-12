<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
use App\Http\Controllers\PesapalCheckStatus;
use App\Models\Transaction;



class IpnPesaPalController extends Controller
{
   
    public function pesapalIpn(Request $request)
    {
            $MerchantReference = $request->get('pesapal_merchant_reference');
            $TrackingId = $request->get('pesapal_transaction_tracking_id');       
            $Notification = $request->get('pesapal_notification_type');
            $checkStatus 				= new PesapalCheckStatus();

            if($Notification=="CHANGE" && $TrackingId!=''){
                
                $transactionDetails	 = $checkStatus->getTransactionDetails($MerchantReference,$TrackingId);             

                $transaction = Transaction::where('reference',$transactionDetails['pesapal_merchant_reference'])->first();
                $transaction->status=$transactionDetails['status'];
                $transaction->paymentMethod = $transactionDetails['payment_method'];
                $transaction->trackingId= $transactionDetails['pesapal_transaction_tracking_id'];
                $transaction->save();
                
                $resp	= "pesapal_notification_type=$pesapalNotification".		
				  "&pesapal_transaction_tracking_id=$pesapalTrackingId".
				  "&pesapal_merchant_reference=$pesapalMerchantReference";
				  
                ob_start();
                echo $resp;
                ob_flush();
                exit; 
            }
        
    }
}

