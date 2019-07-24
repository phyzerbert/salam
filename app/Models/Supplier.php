<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name', 'company', 'email', 'phone_number', 'address', 'city',
    ];

    public function purchases(){
        return $this->hasMany('App\Models\Purchase');
    }
}
