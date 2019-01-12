<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SwitchboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $days = ['Sun' => 'ראשון', 'Mon' => 'שני', 'Tue' => 'שלישי', 'Wed' => 'רביעי', 'Thu' => 'חמישי'];

        $calls = [
            [
                'agent_id' => 1,
                'customer_id' => 1,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived = Carbon::create(2018, 12, 2, 15, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 2, 15, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 2, 15, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],

            [
                'agent_id' => 1,
                'customer_id' => 1,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived = Carbon::create(2018, 12, 2, 18, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 2, 18, 38, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 2, 18, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],

            [

                'agent_id' => 2,
                'customer_id' => 2,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 2, 15, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 2, 15, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 2, 15, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 3,
                'customer_id' => 3,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 2, 15, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 2, 15, 41, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 2, 15, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            // till here 1
            [
                'agent_id' => 1,
                'customer_id' => 1,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 2, 16, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 2, 16, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 2, 16, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 2,
                'customer_id' => 3,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 2, 16, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 2, 16, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 2, 16, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to
            ],
            [
                'agent_id' => 2,
                'customer_id' => 2,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 2, 17, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 2, 17, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 2, 17, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],

//            till here 2
            [
                'agent_id' => 1,
                'customer_id' => 2,
                'abanded' => 0,
                'incoming_call' => 0,
                'time_call_received' => null,
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 3, 17, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 3, 17, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => null, // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 2,
                'customer_id' => 1,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 3, 17, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 3, 17, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 3, 17, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 3,
                'customer_id' => 3,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 3, 17, 27, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 3, 17, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 3, 17, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],

            //            till here 3
            [
                'agent_id' => 1,
                'customer_id' => 2,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 4, 14, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 4, 15, 30, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 4, 17, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 2,
                'customer_id' => 3,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 4, 17, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 4, 18, 01, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 4, 18, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 3,
                'customer_id' => 1,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 4, 8, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 4, 8, 40, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 4, 9, 17, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],

            //            till here 4
            [
                'agent_id' => 1,
                'customer_id' => 2,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 5, 10, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 5, 10, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 5, 11, 38, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 1,
                'customer_id' => 3,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 5, 18, 15, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 5, 18, 20, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 5, 18, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 2,
                'customer_id' => 1,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 5, 17, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 5, 17, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 5, 17, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],

            //            till here 5
            [
                'agent_id' => 1,
                'customer_id' => 2,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 6, 9, 32, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 6, 9, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 6, 10, 15, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 2,
                'customer_id' => 1,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 6, 17, 01, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 6, 17, 10, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 6, 17, 50, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 3,
                'customer_id' => 3,
                'abanded' => 0,
                'incoming_call' => 0,
                'time_call_received' => null,
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 6, 17, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 6, 17, 58, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => null, // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],

            //            till here 6
            [
                'agent_id' => 1,
                'customer_id' => 2,
                'abanded' => 0,
                'incoming_call' => 0,
                'time_call_received' => null,
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 6, 18, 45, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 6, 19, 8, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => null, // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 2,
                'customer_id' => 1,
                'abanded' => 0,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 6, 19, 8, 45),
                'time_call_answered' => $timeCallAnswered = Carbon::create(2018, 12, 6, 19, 20, 45),
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 6, 20, 30, 30),
                'day' => $days[$dayInWeek = $timeCallAnswered->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallAnswered)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => $timeCallAnswered->diff($timeCallDisconnected)->format('%H:%I:%S') // amount of time between answered to disconnected
            ],

//            with abandoned calls
            [
                'agent_id' => 1,
                'customer_id' => 1,
                'abanded' => 1,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 9, 10, 8, 45),
                'time_call_answered' => null,
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 9, 10, 30, 30),
                'day' => $days[$dayInWeek = $timeCallDisconnected->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallDisconnected)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => null // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 2,
                'customer_id' => 2,
                'abanded' => 1,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 9, 12, 8, 45),
                'time_call_answered' => null,
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 9, 12, 20, 30),
                'day' => $days[$dayInWeek = $timeCallDisconnected->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallDisconnected)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => null // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 3,
                'customer_id' => 3,
                'abanded' => 1,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 9, 10, 30, 45),
                'time_call_answered' => null,
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 9, 10, 52, 30),
                'day' => $days[$dayInWeek = $timeCallDisconnected->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallDisconnected)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' =>null // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 1,
                'customer_id' => 1,
                'abanded' => 1,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 9, 13, 8, 45),
                'time_call_answered' => null,
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 9, 13, 30, 30),
                'day' => $days[$dayInWeek = $timeCallDisconnected->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallDisconnected)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => null // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 2,
                'customer_id' => 1,
                'abanded' => 1,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 9, 17, 8, 45),
                'time_call_answered' =>null,
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 9, 17, 45, 30),
                'day' => $days[$dayInWeek = $timeCallDisconnected->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallDisconnected)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => null // amount of time between answered to disconnected
            ],
            [
                'agent_id' => 3,
                'customer_id' => 2,
                'abanded' => 1,
                'incoming_call' => 1,
                'time_call_received' => $timeCallReceived =  Carbon::create(2018, 12, 9, 18, 8, 45),
                'time_call_answered' => null,
                'time_call_disconnected' => $timeCallDisconnected = Carbon::create(2018, 12, 9, 18, 30, 30),
                'day' => $days[$dayInWeek = $timeCallDisconnected->format('D')],
                'standby_time' => $timeCallReceived->diff($timeCallDisconnected)->format('%H:%I:%S'), // amount of time between received to answered
                'call_time' => null // amount of time between answered to disconnected
            ],
        ];


        // here i will do for each on the $calls associative ARRAY and insert to DB

            DB::table('switchboard')->insert($calls);






    }
}

