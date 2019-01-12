<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\Services\SwitchBoardService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
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
        $customers = Customer::all();

        return view('customers')->with(compact('customers'));
    }

    /**
     * Display a one resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getById($id)
    {
        $customer = Customer::find($id);

        $customerCalls = $customer->switchboard;



        $standByTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $callTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $incomingCalls = 0;
        $dates = [];


        foreach ($customerCalls as $customerCall){
            $dates [] = $customerCall->time_call_disconnected;
            $standByTimeCustomer = Carbon::parse($customerCall->standby_time);
            $callTimeCustomer = Carbon::parse($customerCall->call_time);
            if($customerCall->incoming_call == 1){
                $incomingCalls++;
                $standByTimeTotal->addHours($standByTimeCustomer->format('H'))->addMinutes($standByTimeCustomer->format('i'))->addSeconds($standByTimeCustomer->format('s'));
            }
            $callTimeTotal->addHours($callTimeCustomer->format('H'))->addMinutes($callTimeCustomer->format('i'))->addSeconds($callTimeCustomer->format('s'));


        }


        $standTime = $standByTimeTotal->format('H:i:s');
        $callTime = $callTimeTotal->format('H:i:s');
        $standByTimeAvg = $this->switchBoardService->getAvgTimeForCall($standTime,$incomingCalls);
        $callTimeAvg = $this->switchBoardService->getAvgTimeForCall($callTime,count($customerCalls));

        $maxDate = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->format('d-m-Y');
        $minDate = Carbon::createFromFormat('Y-m-d H:i:s', min($dates))->format('d-m-Y');

        $diffInDaysWorking = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', min($dates)));

        if($diffInDaysWorking == 0){
            $avgCallPerDay = count($customerCalls) / ($diffInDaysWorking+2);
        }
        else {
            $avgCallPerDay = count($customerCalls) / ($diffInDaysWorking + 1);
        }



        $customerObj = [
            'customer' => $customer,
            'switchboard' => $customer->switchboard,
            'standByTimeAvg' => $standByTimeAvg,
            'callTimeAvg' => $callTimeAvg,
            'maxDate' => $maxDate,
            'minDate' => $minDate,
            'avgCallPerDay' =>$avgCallPerDay
        ];
        return  $customerObj;


    }


    public function dateRange($id,$startDate, $endDate){


        $startDateTime = $startDate.' 00:00:00.000000';
        $endDateTime  = $endDate.' 23:59:59.000000';


        $customerCalls = DB::table('switchboard')
            ->where('customer_id', $id)
            ->whereBetween('time_call_disconnected', array($startDateTime,$endDateTime))
            ->get();

        $standByTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $callTimeTotal =   Carbon::createFromFormat('H:i:s', '00:00:00');
        $incomingCalls = 0;
        $dates = [];

        foreach ($customerCalls as $call){
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
        $callTimeAvg = $this->switchBoardService->getAvgTimeForCall($callTime,count($customerCalls));


        $maxDate = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->format('d-m-Y');
        $minDate = Carbon::createFromFormat('Y-m-d H:i:s', min($dates))->format('d-m-Y');

        $diffInDaysWorking = Carbon::createFromFormat('Y-m-d H:i:s', max($dates))->diffInDays(Carbon::createFromFormat('Y-m-d H:i:s', min($dates)));


        if($diffInDaysWorking == 0){
            $avgCallPerDay = count($customerCalls) / ($diffInDaysWorking+2);
        }
        else {
            $avgCallPerDay = count($customerCalls) / ($diffInDaysWorking + 1);
        }


        $bestDayInRange = $this->switchBoardService->getBestDayFromRange($startDateTime, $endDateTime );

        $customer = Customer::find($id);



        $switchRange = [
            'customer' => $customer,
            'switchboard' => $customerCalls,
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
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
