<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>smarticket - switchboard</title>


    <!-- Bootstrap core CSS-->
    <link href="{{asset('boo/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="{{asset('boo/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">


    <!-- Page level plugin CSS-->
    <link href="{{asset('boo/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">


    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css" rel="stylesheet">

    {{--mine css--}}
    <link href="{{asset('css/my-css.css')}}" rel="stylesheet">

    {{--//hebrew--}}
    {{--<link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">--}}


</head>

<body id="page-top" style="text-align: right;">

<div id="wrapper">

    <!-- Sidebar -->

    <ul class="sidebar navbar-nav">
        <li class="nav-item active">
            <a class="nav-link">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>מרכזייה סמרט-טיקט</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="scroll-table">
                <i class="fas fa-fw fa-table"></i>
                <span>לטבלה</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="scroll-graphs">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>לגרפים והשוואות</span></a>
        </li>

    </ul>

    <div id="content-wrapper">

        <div class="container-fluid">


            <div class="row">
                <div class="col-xl-2 col-sm-2 mb-2"></div>
                <h4 class="col-xl-8 col-sm-8 mb-8" id="datesArea"></h4>
                <div class="col-xl-2 col-sm-2 mb-2"></div>
            </div>

            <div class="row">
                <div id="callPercent" class="col-xl-4 col-sm-4 mb-4" style="height: 370px; width: 100%;"></div>
                <div id="avgTimePercent" class="col-xl-4 col-sm-4 mb-4" style="height: 370px; width: 100%;"></div>
                <div id="abandedPercent" class="col-xl-4 col-sm-4 mb-4" style="height: 370px; width: 100%;"></div>
            </div>
            <!-- Icon Cards-->
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-primary o-hidden h-100">
                        <div class="card-body">

                            <div class="mr-5" style="font-weight: bold" id="callTotal">סה"כ שיחות
                                - {{count($switchboard)}}</div>

                            <?php
                            $incomingCalls = 0;
                            $outComingCalls = 0;

                            foreach ($switchboard as $call) {
                                if ($call->incoming_call == 1) {
                                    $incomingCalls++;
                                } else {
                                    $outComingCalls++;
                                }
                            }
                            ?>


                            <div class="mr-5" style="font-weight: bold" id="incoming"> נכנסות - {{$incomingCalls}}</div>
                            <div class="mr-5" style="font-weight: bold" id="outcoming"> יוצאות
                                - {{ $outComingCalls }} </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-warning o-hidden h-100">
                        <div class="card-body">

                            <div class="mr-5" style="font-weight: bold" id="avgPerDay"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-body">

                            <div class="mr-5" style="font-weight: bold" id="avgStandTime"></div>
                            <div class="mr-5" style="font-weight: bold" id="avgCallTime"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-danger o-hidden h-100">
                        <div class="card-body">

                            <div class="mr-5" style="font-weight: bold">זמן המתנה מקסימלי בדקות - 10</div>
                            <div class="mr-5" style="font-weight: bold" id="maxStandByTime">זמן שיחה מקסימלי בדקות -
                                30
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--חתכים לפי נציג\נציגים לקוח\לקוחות, טווח תאריכים, יום בשבוע.--}}
            <div class="row">
                <div class="col-xl-2 col-sm-4 mb-2">
                    <div class="card text-white bg-info o-hidden h-100">
                        <div class="card-body">

                            <div class="mr-5">
                                <div class="form-group">
                                    <span style="font-size:18px;font-weight:500;">מתחילת</span>

                                    <input type="date" name="startDate" class="form-control date-range-filter"
                                           id="start-date" min="2018-12-02" max="2018-12-09">
                                </div>
                            </div>
                            <div class="mr-5">
                                <div class="form-group">
                                    <span style="font-size:18px;font-weight:500;">עד</span>
                                    <input type="date" name="endDate" id="end-date"
                                           class="form-control date-range-filter" min="2018-12-02" max="2018-12-09">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-4 mb-2">
                    <div class="card text-white bg-info o-hidden h-100">
                        <div class="card-body">

                            <div class="form-group">
                                <span style="font-size:18px;font-weight:500;" multiple="true">לקוח</span>
                                <select id="select-customer" multiple="true">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-4 mb-2">
                    <div class="card text-white bg-info o-hidden h-100">
                        <div class="card-body">

                            <div class="form-group">
                                <span style="font-size:18px;font-weight:500;" multiple="true">נציג</span>
                                <select id="select-agent" multiple="true">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-4 mb-2">
                    <div class="card text-white bg-info  h-100">
                        <div class="card-body">

                            <div class="form-group">
                                <span style="font-size:18px;font-weight:500;" multiple="true">יום</span>
                                <select id="day-select" multiple="true">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-4 mb-2">
                    <div class="card text-white bg-info  h-100">
                        <div class="card-body">

                            <div class="form-group">
                                <span style="font-size:18px;font-weight:500;" multiple="true">נכנסת/יוצאת</span>
                                <select id="incomingSelect" multiple="true">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-4 mb-2">
                    <div class="card text-white bg-info  h-100">
                        <div class="card-body">

                            <div class="form-group">
                                <span style="font-size:18px;font-weight:500;" multiple="true">ננטשה/נענתה</span>
                                <select id="abandedSelect" multiple="true">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-sm-8 mb-4">
                </div>
                <button class="col-xl-4 col-sm-12 mb-4 btn btn-info" id="displayGraphs">
                    לחץ כאן לנתונים על נציגים ולקוחות שנבחרו לפי תאריך
                </button>
                <div class="col-xl-4 col-sm-8 mb-4">

                </div>
            </div>

            <!-- DataTables Example -->
            <div class="card mb-3" style="direction: rtl">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    טבלת שיחות
                    &nbsp;
                    <span class="fa fa-square" style="color: orangered; direction: ltr"> - חריגה ממתין ושיחה</span>
                    <span class="fa fa-square" style="color: firebrick; direction: ltr"> - חריגה שיחה</span>
                    <span class="fa fa-square" style="color: cornflowerblue; direction: ltr"> - חריגה ממתין </span>
                    <span class="fa fa-square" style="color: red; direction: ltr">  - ננטשה </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="switchboard" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th></th>
                                <th>שם נציג</th>
                                <th>מספר שלוחה</th>
                                <th>שם לקוח</th>
                                <th>טלפון לקוח</th>
                                <th>שיחה נכנסת\יוצאת</th>
                                <th>ננטשה\נענתה</th>
                                <th>זמן קבלת שיחה</th>
                                <th>זמן מענה שיחה</th>
                                <th>זמן ניתוק שיחה</th>
                                <th>יום בשבוע</th>
                                <th>זמן המתנה</th>
                                <th>זמן שיחה</th>
                            </tr>
                            </thead>
                            {{--<tfoot>--}}
                            {{--<tr>--}}
                            {{--<th></th>--}}
                            {{--<th>שם נציג</th>--}}
                            {{--<th>מספר שלוחה</th>--}}
                            {{--<th>שם לקוח</th>--}}
                            {{--<th>טלפון לקוח</th>--}}
                            {{--<th>שיחה נכנסת\יוצאת</th>--}}
                            {{--<th>זמן קבלת שיחה</th>--}}
                            {{--<th>זמן מענה שיחה</th>--}}
                            {{--<th>זמן ניתוק שיחה</th>--}}
                            {{--<th>יום בשבוע</th>--}}
                            {{--<th>זמן המתנה</th>--}}
                            {{--<th>זמן שיחה</th>--}}
                            {{--</tr>--}}
                            {{--</tfoot>--}}
                            <tbody>
                            @foreach($switchboard as $call)
                                @if($call->standby_time > '00:10:00' && $call->call_time > '00:30:00')
                                    <tr class="call-data" style="background-color: orangered">
                                @elseif($call->call_time > '00:30:00')
                                    <tr class="call-data" style="background-color: indianred">
                                @elseif($call->standby_time > '00:10:00' && $call->abanded == 0)
                                    <tr class="call-data" style="background-color: cornflowerblue">
                                @elseif($call->abanded == 1)
                                    <tr class="call-data" style="background-color: red">
                                @else
                                    <tr class="call-data">
                                        @endif

                                        <td></td>
                                        <td>{{$call->agent->agent_name}}</td>
                                        <td>{{$call->agent->extension_number}}</td>
                                        <td>{{$call->customer->customer_name}}</td>
                                        <td>{{$call->customer->phone_number}}</td>
                                        @if($call->incoming_call == 1)
                                            <td>נכנסת</td>
                                        @else
                                            <td>יוצאת</td>
                                        @endif
                                        @if($call->abanded == 1)
                                            <td>ננטשה</td>
                                        @else
                                            <td>נענתה</td>
                                        @endif
                                        <td>{{$call->time_call_received}}</td>
                                        <td>{{$call->time_call_answered}}</td>
                                        <td>{{$call->time_call_disconnected}}</td>
                                        <td>{{$call->day}}</td>
                                        <td class="td-stand"
                                            data-stand="{{$call->standby_time}}">{{$call->standby_time}}</td>
                                        <td class="td-call" data-call="{{$call->call_time}}">{{$call->call_time}}</td>
                                    </tr>

                                    @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted"></div>
            </div>


            {{--//agent area chart--}}
            <div id="charts-area"></div>


        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © GALA_WEB 2019</span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('boo/jquery/jquery.min.js')}}"></script>
<script src="{{asset('boo/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('boo/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Page level plugin JavaScript-->
<script src="{{asset('boo/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('boo/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('boo/datatables/dataTables.bootstrap4.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('js/sb-admin.min.js')}}"></script>

<!-- Demo scripts for this page-->
{{--<script src="{{asset('js/demo/datatables-demo.js')}}"></script>--}}
{{--<script src="{{asset('js/demo/chart-area-demo.js')}}"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
{{--<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>--}}
<script src="https://canvasjs.com/assets/script/jquery-ui.1.11.2.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

{{--mine js--}}
<script src="{{asset('js/switchboard.js')}}"></script>
</body>
</html>

