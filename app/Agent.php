<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';

    protected $fillable = ['extension_number', 'agent_name'];


    public function switchboard()
    {
        return $this->hasMany('App\SwitchBoard');
    }
}
