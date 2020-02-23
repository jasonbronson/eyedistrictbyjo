<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingModel extends Model
{
    protected $table = 'shipping';
    protected $fillable = ['user_id', 'firstname', 'lastname', 'street1', 'street2', 'company', 'postcode', 'city', 'region_id', 'country_id', 'telephone'];
    

}
