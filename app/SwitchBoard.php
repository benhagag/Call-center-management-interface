<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SwitchBoard extends Model
{

    protected $table = 'switchboard';
    protected $fillable = ['agent_id', 'customer_id', 'incoming_call', 'time_call_received', 'time_call_answered','time_call_disconnected','standby_time','call_time'];

    public function agent()
    {
        return $this->belongsTo('App\Agent');
    }


    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }


}
