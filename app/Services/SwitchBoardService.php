<?php

namespace App\Services;


use App\Customer;
use App\SwitchBoard;
use App\Agent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class SwitchBoardService
{

    public $days;

    public function __construct()
    {

        $this->days = ['Sun' => 'ראשון', 'Mon' => 'שני', 'Tue' => 'שלישי', 'Wed' => 'רביעי', 'Thu' => 'חמישי'];
    }

    public function getAvgTimeForCall($hhmmss, $counter)
    {
        if ($hhmmss == "00:00:00"){
            return 0;
        }
        $arrayOfTime = explode(':', $hhmmss);
        $totalInMinutes = ($arrayOfTime[0] * 60) + $arrayOfTime[1] + ($arrayOfTime[2] / 60);
        return number_format($totalInMinutes / $counter, 1);
    }

    public function getDistinguishedAgent()
    {

        $agentId = SwitchBoard::select('agent_id')
            ->groupBy('agent_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get();
        $countCalls = SwitchBoard::where('agent_id', $agentId[0]['agent_id'])->count();
        $agent = Agent::find($agentId);

        return $agent = [
            'countCalls' => $countCalls,
            'agentName' => $agent[0]->agent_name
        ];


    }

    public function getPreferredCustomer()
    {

        $customerId = SwitchBoard::select('customer_id')
            ->groupBy('customer_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get();

        $countCalls = SwitchBoard::where('customer_id', $customerId[0]['customer_id'])->count();
        $customer = Customer::find($customerId);

        return $customer = [
            'countCalls' => $countCalls,
            'customerName' => $customer[0]->customer_name
        ];
    }

    public function getBestDay()
    {
        $bestDay = SwitchBoard::select('day')
            ->groupBy('day')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get();

        $countCalls = SwitchBoard::where('day', $bestDay[0]['day'])->count();

        return $day = [
            'countCalls' => $countCalls,
            'day' => $bestDay
        ];
    }

    public function getBestDayFromRange($start, $end)
    {

        $bestDay = SwitchBoard::select('day')
            ->groupBy('day')
            ->whereBetween('time_call_disconnected', [$start, $end])
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get();

        return $bestDay;

    }



    public function getAllDays($switchboard)
    {

        $daysArr = [];

        foreach ($switchboard as $call) {
            $daysArr[] = $call->day;
        }

        $days = array_unique($daysArr);

        return $days;


    }

    function  getDynamicDataAgent($agentCalls,$startDate ,$endDate,$id){


        $startDateTime = $startDate.' 00:00:00.000000';
        $endDateTime  = $endDate.' 23:59:59.000000';



        $standByTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $callTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $incomingCalls = 0;
        $outComingCalls = 0;
        $abandedCalls = 0;
        $unAbandedCalls = 0;
        $dates = [];

        foreach ($agentCalls as $call){
            $dates [] = $call->time_call_disconnected;
            $standByTimeAgent = Carbon::parse($call->standby_time);
            $callTimeAgent = Carbon::parse($call->call_time);
            if($call->incoming_call == 1){
                $incomingCalls++;
                $standByTimeTotal->addHours($standByTimeAgent->format('H'))->addMinutes($standByTimeAgent->format('i'))->addSeconds($standByTimeAgent->format('s'));
            }else{
                    $outComingCalls++;
            }
            if($call->abanded == 0){
                $unAbandedCalls++;
            $callTimeTotal->addHours($callTimeAgent->format('H'))->addMinutes($callTimeAgent->format('i'))->addSeconds($callTimeAgent->format('s'));
            }else{
                $abandedCalls++;
            }
        }

        $standTime = $standByTimeTotal->format('H:i:s');
        $callTime = $callTimeTotal->format('H:i:s');
        $standByTimeAvg = $this->getAvgTimeForCall($standTime,$incomingCalls);
        $callTimeAvg = $this->getAvgTimeForCall($callTime,$unAbandedCalls);


        $maxDate = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->format('d-m-Y');
        $minDate = Carbon::createFromFormat('Y-m-d H:i:s', min($dates))->format('d-m-Y');

        $diffInDaysWorking = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', min($dates)));


        if($diffInDaysWorking == 0){
            $avgCallPerDay = count($agentCalls) / ($diffInDaysWorking+2);
        }
        else {
            $avgCallPerDay = count($agentCalls) / ($diffInDaysWorking + 1);
        }



        $bestDayInRange = $this->getBestDayFromRange($startDateTime, $endDateTime );

        $agent = Agent::find($id);



        $switchRange = [
            'agent' => $agent,
            'switchboard' => $agentCalls,
            'standByTimeAvg' => $standByTimeAvg,
            'callTimeAvg' => $callTimeAvg,
            'maxDate' => $maxDate,
            'minDate' => $minDate,
            'incomingCalls' => $incomingCalls,
            'abandedCalls'=> $abandedCalls,
            'outComingCalls' => $outComingCalls,
            'avgCallPerDay' => $avgCallPerDay,
            'bestDayInRange' => $bestDayInRange[0]['day']
        ];
        return  $switchRange;

    }


    function  getDynamicDataCustomer($customerCalls,$startDate ,$endDate, $id){

        $startDateTime = $startDate.' 00:00:00.000000';
        $endDateTime  = $endDate.' 23:59:59.000000';



        $standByTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $callTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $incomingCalls = 0;
        $outComingCalls = 0;
        $abandedCalls = 0;
        $unAbandedCalls = 0;
        $dates = [];

        foreach ($customerCalls as $call){
            $dates [] = $call->time_call_disconnected;
            $standByTimeAgent = Carbon::parse($call->standby_time);
            $callTimeAgent = Carbon::parse($call->call_time);
            if($call->incoming_call == 1){
                $incomingCalls++;
                $standByTimeTotal->addHours($standByTimeAgent->format('H'))->addMinutes($standByTimeAgent->format('i'))->addSeconds($standByTimeAgent->format('s'));
            }else{
                $outComingCalls++;
            }
            if($call->abanded == 0){
                $unAbandedCalls++;
            $callTimeTotal->addHours($callTimeAgent->format('H'))->addMinutes($callTimeAgent->format('i'))->addSeconds($callTimeAgent->format('s'));
            }else{
                $abandedCalls++;
            }
        }

        $standTime = $standByTimeTotal->format('H:i:s');
        $callTime = $callTimeTotal->format('H:i:s');
        $standByTimeAvg = $this->getAvgTimeForCall($standTime,$incomingCalls);
        $callTimeAvg = $this->getAvgTimeForCall($callTime,$unAbandedCalls);


        $maxDate = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->format('d-m-Y');
        $minDate = Carbon::createFromFormat('Y-m-d H:i:s', min($dates))->format('d-m-Y');

        $diffInDaysWorking = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', min($dates)));


        if($diffInDaysWorking == 0){
            $avgCallPerDay = count($customerCalls) / ($diffInDaysWorking+2);
        }
        else {
            $avgCallPerDay = count($customerCalls) / ($diffInDaysWorking + 1);
        }


        $bestDayInRange = $this->getBestDayFromRange($startDateTime, $endDateTime );

        $customer = Customer::find($id);



        $switchRange = [
            'customer' => $customer,
            'switchboard' => $customerCalls,
            'standByTimeAvg' => $standByTimeAvg,
            'callTimeAvg' => $callTimeAvg,
            'maxDate' => $maxDate,
            'minDate' => $minDate,
            'incomingCalls' => $incomingCalls,
            'abandedCalls'=> $abandedCalls,
            'outComingCalls' => $outComingCalls,
            'avgCallPerDay' => $avgCallPerDay,
            'bestDayInRange' => $bestDayInRange[0]['day']
        ];
        return  $switchRange;

    }


}
