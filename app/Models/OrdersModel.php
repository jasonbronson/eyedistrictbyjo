<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id', 'cart' ];
    

}
