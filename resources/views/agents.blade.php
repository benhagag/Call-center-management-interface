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

    <script src="{{asset('js/agents.js')}}"></script>


</head>
<body>


@extends('layouts.navbar')

@section('content')


    <div class="container">
        <div class="row">
            <h1>נציגים</h1>


            <table id="agents" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>שם נציג</th>
                    <th>מספר שלוחה</th>
                </tr>
                </thead>
                <tbody>

                @foreach($agents as $agent)
                    <tr>
                        <td class='agent-name' data-id="{{$agent->id}}" style="cursor: pointer">{{$agent->agent_name}}</td>
                        <td>{{$agent->extension_number}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div id="agent-data">

            </div>
            <hr>


            <h3> נתונים בין תאריכים לנציג</h3>

            <div class="form-group">
                <label for="select-agent">בחירת נציג</label>
                <select class="form-control" id="select-agent">
                    @foreach($agents as $agent)
                        <option value="{{$agent->id}}">{{$agent->agent_name}}</option>
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
