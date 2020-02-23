<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    protected $table = 'products';
    protected $fillable = ['category', 'sku', 'lens_option', 'price', 'details' ];
    

}
