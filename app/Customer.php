<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['customer_name', 'phone_number'];

    public function switchboard()
    {
        return $this->hasMany('App\SwitchBoard');
    }

}
