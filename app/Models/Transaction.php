<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable =[ 'currency','amount', 'status','reference','userId','paymentMethod','trackingId'];
}
