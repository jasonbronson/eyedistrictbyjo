<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionModel extends Model
{
    protected $table = 'prescription';
    protected $fillable = ['user_id', 'filename'];
    

}
