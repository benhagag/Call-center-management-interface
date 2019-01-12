<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>smarticket - switchboard</title>

    {{--dataTable--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('datatable/datatables.min.css') }}"/>--}}
    {{--<script type="text/javascript" src="{{ asset('datatable/datatables.min.js') }}" defer></script>--}}

    {{--//bootstrap--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    {{--datatable--}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('js/customers.js')}}"></script>


</head>
<body>


@extends('layouts.navbar')

@section('content')


    <div class="container">
        <div class="row">
            <h1>לקוחות</h1>


            <table id="customers" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>שם לקוח</th>
                    <th>מספר טלפון</th>
                </tr>
                </thead>
                <tbody>

                @foreach($customers as $customer)
                    <tr>
                        <td class='customer-name' data-id="{{$customer->id}}" style="cursor: pointer">{{$customer->customer_name}}</td>
                        <td>{{$customer->phone_number}}</td>
                    </tr>
                @endforeach


                </tbody>
            </table>

            <div id="customer-data">

            </div>

            <hr>


            <h3> נתונים בין תאריכים ללקוח</h3>

            <div class="form-group">
                <label for="select-agent">בחירת לקוח</label>
                <select class="form-control" id="select-customer">
                    @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="start-date">מתחילת</label>
                <input type="date" name="startDate" class="form-control" id="start-date" min="2018-12-02" max="2018-12-06">
            </div>

            <div class="form-group">
                <label for="end-date">עד</label>
                <input type="date" name="endDate" id="end-date" class="form-control" min="2018-12-02" max="2018-12-06">
            </div>

            <button class="btn btn-info" id="switchboard-range">חפש</button>
            <hr>
            <br>
            <div id="switchboard-range-data">

            </div>


            {{--end of div row--}}
        </div>
    </div>
</body>
</html>
@endsection
