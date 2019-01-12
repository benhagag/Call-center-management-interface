<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Customer;
use App\SwitchBoard;
use Illuminate\Http\Request;
use App\Services\SwitchBoardService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class SwitchBoardController extends Controller
{

    private $switchBoardService;
    public $days;

    public function __construct(SwitchBoardService $switchBoardService)
    {

        $this->switchBoardService = $switchBoardService;
        $this->days = ['Sun' => 'ראשון', 'Mon' => 'שני', 'Tue' => 'שלישי', 'Wed' => 'רביעי', 'Thu' => 'חמישי'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $switchboard = SwitchBoard::all();
        $distinguishedAgent = $this->switchBoardService->getDistinguishedAgent();
        $preferredCustomer = $this->switchBoardService->getPreferredCustomer();
        $bestDayInWeek = $this->switchBoardService->getBestDay();
        $allDaysInWeek = $this->switchBoardService->getAllDays($switchboard);
        return view('switchboard')->with(compact('switchboard', 'distinguishedAgent', 'preferredCustomer', 'bestDayInWeek', 'allDaysInWeek'));
    }

    public function dateRange($startDate, $endDate)
    {

        $startDateTime = $startDate . ' 00:00:00.000000';
        $endDateTime = $endDate . ' 23:59:59.000000';
        $switchBoardRange = SwitchBoard::whereBetween('time_call_disconnected', [$startDateTime, $endDateTime])->get();

        $standByTimeTotal = Carbon::createFromFormat('H:i:s', '00:00:00');
        $callTimeTotal = Carbon::createFromFormat('H:i:s', '00:00:00');
        $incomingCalls = 0;
        $abandonedCalls = 0;
        $unabandedCalls = 0;
        $dates = [];

        foreach ($switchBoardRange as $call) {
            $dates [] = $call->time_call_disconnected;
            $standByTimeAgent = Carbon::parse($call->standby_time);
            $callTimeAgent = Carbon::parse($call->call_time);
            if ($call->incoming_call == 1) {
                $incomingCalls++;
                $standByTimeTotal->addHours($standByTimeAgent->format('H'))->addMinutes($standByTimeAgent->format('i'))->addSeconds($standByTimeAgent->format('s'));
            }
            if($call->abended == 0){
                $unabandedCalls ++;
            $callTimeTotal->addHours($callTimeAgent->format('H'))->addMinutes($callTimeAgent->format('i'))->addSeconds($callTimeAgent->format('s'));
            }
        }


        $standTime = $standByTimeTotal->format('H:i:s');
        $callTime = $callTimeTotal->format('H:i:s');
        $standByTimeAvg = $this->switchBoardService->getAvgTimeForCall($standTime, $incomingCalls);
        $callTimeAvg = $this->switchBoardService->getAvgTimeForCall($callTime, $unabandedCalls);


        $maxDate = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->format('d-m-Y');
        $minDate = Carbon::createFromFormat('Y-m-d H:i:s', min($dates))->format('d-m-Y');

        $diffInDaysWorking = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', min($dates)));


//        if ($diffInDaysWorking == 0) {
//            $avgCallPerDay = count($switchBoardRange) / ($diffInDaysWorking + 2);
//        } else {
            $avgCallPerDay = count($switchBoardRange) / ($diffInDaysWorking + 1);
//        }


        $bestDayInRange = $this->switchBoardService->getBestDayFromRange($startDateTime, $endDateTime);


        $switchRange = [
            'switchboard' => $switchBoardRange,
            'standByTimeAvg' => $standByTimeAvg,
            'callTimeAvg' => $callTimeAvg,
            'maxDate' => $maxDate,
            'minDate' => $minDate,
            'avgCallPerDay' => $avgCallPerDay,
            'bestDayInRange' => $bestDayInRange[0]['day']
        ];
        return $switchRange;


    }


    public function getDay($day)
    {

        $switchBoard = SwitchBoard::where('day', $day)->get();

        $standByTimeTotal = Carbon::createFromFormat('H:i:s', '00:00:00');
        $callTimeTotal = Carbon::createFromFormat('H:i:s', '00:00:00');
        $incomingCalls = 0;

        foreach ($switchBoard as $call) {
            $standByTimeAgent = Carbon::parse($call->standby_time);
            $callTimeAgent = Carbon::parse($call->call_time);
            if ($call->incoming_call == 1) {
                $incomingCalls++;
                $standByTimeTotal->addHours($standByTimeAgent->format('H'))->addMinutes($standByTimeAgent->format('i'))->addSeconds($standByTimeAgent->format('s'));
            }
            $callTimeTotal->addHours($callTimeAgent->format('H'))->addMinutes($callTimeAgent->format('i'))->addSeconds($callTimeAgent->format('s'));
        }

        $standTime = $standByTimeTotal->format('H:i:s');
        $callTime = $callTimeTotal->format('H:i:s');
        $standByTimeAvg = $this->switchBoardService->getAvgTimeForCall($standTime, $incomingCalls);
        $callTimeAvg = $this->switchBoardService->getAvgTimeForCall($callTime, count($switchBoard));

        $switchBoard = [
            'switchboard' => $switchBoard,
            'standByTimeAvg' => $standByTimeAvg,
            'callTimeAvg' => $callTimeAvg,
        ];


        return $switchBoard;
    }


    public function getDataGraphs($dataForGraphsJson)
    {

        $dataForGraphs = json_decode($dataForGraphsJson);

            $startDateTime = $dataForGraphs->dates[0] . ' 00:00:00.000000';
            $endDateTime = $dataForGraphs->dates[1] . ' 23:59:59.000000';

// get customers id

        if(empty($dataForGraphs->customers)){

            $customers = Customer::select('id')
                ->groupBy('id')
                ->get();

        }else{
            $customers = Customer::select('id')
                ->groupBy('id')
                ->whereIn('customer_name', $dataForGraphs->customers)
                ->get();
        }

        $customersArr = [];
        foreach ($customers as $customer){
            $customersArr [ $customer['id']] = [$customer['id']];
        }



//get agents id
        if(empty($dataForGraphs->agents)){

            $agents = Agent::select('id')
                ->groupBy('id')
                ->get();

        }else{
            $agents = Agent::select('id')
                ->groupBy('id')
                ->whereIn('agent_name', $dataForGraphs->agents)
                ->get();
        }

        $agentsArr = [];
        foreach ($agents as $agent){
            $agentsArr [$agent['id']] = [$agent['id']];
        }


        if(empty($dataForGraphs->days)){
            $switchBoardForDays = SwitchBoard::all();
            $days = $this->switchBoardService->getAllDays($switchBoardForDays);
        }else{
            $days = $dataForGraphs->days;
        }

//        $agentArr =  [];
//        $customersArr = [];
//        foreach ($agents as $agent){
//
//        }

        $switchBoard = DB::table('switchboard')
            ->whereIn('agent_id', $agents)
            ->whereIn('customer_id', $customers)
            ->whereIn('day',$days)
            ->whereBetween('time_call_disconnected', [$startDateTime, $endDateTime])
            ->get();




        foreach ($switchBoard as $call){
            if(array_key_exists(0,$customersArr[$call->customer_id]) && !is_array($customersArr[$call->customer_id][0])){
                unset($customersArr[$call->customer_id][0]);
            }
            if(array_key_exists(0,$agentsArr[$call->agent_id]) && !is_array($agentsArr[$call->agent_id][0])){
                unset($agentsArr[$call->agent_id][0]);
            }
            array_push($customersArr[$call->customer_id] , $call);
            array_push($agentsArr[$call->agent_id] , $call);
        }

        foreach ($agentsArr as $key => $value){

            if(array_key_exists(0,$value)){

                unset($agentsArr[$key]);
            }

        }

        foreach ($customersArr as $key => $value){

            if(array_key_exists(0,$value)){

                unset($customersArr[$key]);
            }

        }

        $agentsId = [];
        $customersId = [];
            foreach ($agentsArr as $key => $agent){
                $agentsId [] = $key;
                    $dataToAddAgents = $this->switchBoardService->getDynamicDataAgent($agent,$dataForGraphs->dates[0] ,$dataForGraphs->dates[1],$key );
                    $agentsArr [$key]['data'] = $dataToAddAgents;

            }

        foreach ($customersArr as $key => $customer){
            $customersId [] = $key;
            $dataToAddCustomer = $this->switchBoardService->getDynamicDataCustomer($customer,$dataForGraphs->dates[0] ,$dataForGraphs->dates[1],$key );
            $customersArr [$key]['data'] = $dataToAddCustomer;

        }

        $data = [

            'switchBoard' => $switchBoard,
            'agentsId' => $agentsId,
            'agents' => $agentsArr,
            'customersId' => $customersId,
            'customers' => $customersArr
        ];

       return $data;


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SwitchBoard $switchBoard
     * @return \Illuminate\Http\Response
     */
    public function show(SwitchBoard $switchBoard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SwitchBoard $switchBoard
     * @return \Illuminate\Http\Response
     */
    public function edit(SwitchBoard $switchBoard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\SwitchBoard $switchBoard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SwitchBoard $switchBoard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SwitchBoard $switchBoard
     * @return \Illuminate\Http\Response
     */
    public function destroy(SwitchBoard $switchBoard)
    {
        //
    }
}
