<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Services\SwitchBoardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\SwitchBoard;
//use DB;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    private $switchBoardService;

    public function __construct(SwitchBoardService $switchBoardService){

        $this->switchBoardService = $switchBoardService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = Agent::all();


        return view('agents')->with(compact('agents'));
    }


    /**
     * Display a one resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getById($id)
    {
        $agent = Agent::find($id);

        $agentCalls = $agent->switchboard;

        $standByTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $callTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $incomingCalls = 0;
        $dates = [];


        foreach ($agentCalls as $agentCall){
            $dates [] = $agentCall->time_call_disconnected;
            $standByTimeAgent = Carbon::parse($agentCall->standby_time);
            $callTimeAgent = Carbon::parse($agentCall->call_time);
            if($agentCall->incoming_call == 1){
                $incomingCalls++;
              $standByTimeTotal->addHours($standByTimeAgent->format('H'))->addMinutes($standByTimeAgent->format('i'))->addSeconds($standByTimeAgent->format('s'));
            }
           $callTimeTotal->addHours($callTimeAgent->format('H'))->addMinutes($callTimeAgent->format('i'))->addSeconds($callTimeAgent->format('s'));
        }


        $standTime = $standByTimeTotal->format('H:i:s');
        $callTime = $callTimeTotal->format('H:i:s');
        $standByTimeAvg = $this->switchBoardService->getAvgTimeForCall($standTime,$incomingCalls);
        $callTimeAvg = $this->switchBoardService->getAvgTimeForCall($callTime,count($agentCalls));


        $maxDate = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->format('d-m-Y');
        $minDate = Carbon::createFromFormat('Y-m-d H:i:s', min($dates))->format('d-m-Y');

        $diffInDaysWorking = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', min($dates)));

        if($diffInDaysWorking == 0){
            $avgCallPerDay = count($agentCalls) / ($diffInDaysWorking+2);
        }
        else {
            $avgCallPerDay = count($agentCalls) / ($diffInDaysWorking + 1);
        }



        $agentObj = [
            'agent' => $agent,
            'switchboard' => $agent->switchboard,
            'standByTimeAvg' => $standByTimeAvg,
            'callTimeAvg' => $callTimeAvg,
            'maxDate' => $maxDate,
            'minDate' => $minDate,
            'avgCallPerDay' => $avgCallPerDay
        ];
         return  $agentObj;

    }



    public function dateRange($id,$startDate, $endDate){


        $startDateTime = $startDate.' 00:00:00.000000';
        $endDateTime  = $endDate.' 23:59:59.000000';


         $agentCalls = DB::table('switchboard')
            ->where('agent_id', $id)
            ->whereBetween('time_call_disconnected', array($startDateTime,$endDateTime))
            ->get();

        $standByTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $callTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $incomingCalls = 0;
        $dates = [];

        foreach ($agentCalls as $call){
            $dates [] = $call->time_call_disconnected;
            $standByTimeAgent = Carbon::parse($call->standby_time);
            $callTimeAgent = Carbon::parse($call->call_time);
            if($call->incoming_call == 1){
                $incomingCalls++;
                $standByTimeTotal->addHours($standByTimeAgent->format('H'))->addMinutes($standByTimeAgent->format('i'))->addSeconds($standByTimeAgent->format('s'));
            }
            $callTimeTotal->addHours($callTimeAgent->format('H'))->addMinutes($callTimeAgent->format('i'))->addSeconds($callTimeAgent->format('s'));
        }

        $standTime = $standByTimeTotal->format('H:i:s');
        $callTime = $callTimeTotal->format('H:i:s');
        $standByTimeAvg = $this->switchBoardService->getAvgTimeForCall($standTime,$incomingCalls);
        $callTimeAvg = $this->switchBoardService->getAvgTimeForCall($callTime,count($agentCalls));


        $maxDate = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->format('d-m-Y');
        $minDate = Carbon::createFromFormat('Y-m-d H:i:s', min($dates))->format('d-m-Y');

        $diffInDaysWorking = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', min($dates)));


        if($diffInDaysWorking == 0){
            $avgCallPerDay = count($agentCalls) / ($diffInDaysWorking+2);
        }
        else {
            $avgCallPerDay = count($agentCalls) / ($diffInDaysWorking + 1);
        }



        $bestDayInRange = $this->switchBoardService->getBestDayFromRange($startDateTime, $endDateTime );

        $agent = Agent::find($id);



        $switchRange = [
            'agent' => $agent,
            'switchboard' => $agentCalls,
            'standByTimeAvg' => $standByTimeAvg,
            'callTimeAvg' => $callTimeAvg,
            'maxDate' => $maxDate,
            'minDate' => $minDate,
            'avgCallPerDay' => $avgCallPerDay,
            'bestDayInRange' => $bestDayInRange[0]['day']
        ];
        return  $switchRange;


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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(Agent $agent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agent $agent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        //
    }
}
