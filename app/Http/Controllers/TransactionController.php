<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function transactionRecord(): JsonResponse
    {   
        try{
            $transaction = Transaction::select('transactions.currency','transactions.amount','transactions.status','transactions.reference','transactions.userId','transactions.paymentMethod','transactions.created_at as transaction_date','transactions.trackingId','client_users.first_name','client_users.last_name','client_users.email','client_users.phone')
                                    ->join('client_users','client_users.id','=','transactions.userId')
                                    ->orderBy('transaction_date','desc')
                                    ->get();
            return response()->json($transaction,Response::HTTP_OK);
        } catch (\Exception $e) {
             return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } 
    }
}
