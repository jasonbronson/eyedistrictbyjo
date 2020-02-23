<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentsModel extends Model
{
    protected $table = 'payments';
    protected $fillable = ['user_id', 'stripe_customer_id', 'token', 'amount'];
    

}
