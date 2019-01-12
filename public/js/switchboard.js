var url = window.location.href;
$(document).ready(function () {
    var switchTable = $('#switchboard').DataTable({
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "הכל"]],
        "iDisplayLength": 10,
        "order": [[9, "asc"]],
        "language": {
            "lengthMenu": "מספר שורות בדף _MENU_",
            "search": "חיפוש:",
            "info": "דף _PAGE_ מתוך _PAGES_ ",
            "paginate": {
                "first": "ראשון",
                "last": "אחרון",
                "next": "הבא",
                "previous": "הקודם"
            },
        },
        initComplete: function () {
            this.api().columns([1]).every(function () {
                var column = this;
                // console.log(column);
                var select = $("#select-agent");
                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });

            this.api().columns([3]).every(function () {
                var column = this;
                // console.log(column);
                var select = $("#select-customer");
                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
            this.api().columns([10]).every(function () {
                var column = this;
                // console.log(column);
                var select = $("#day-select");
                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });

            this.api().columns([5]).every(function () {
                var column = this;
                // console.log(column);
                var select = $("#incomingSelect");
                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });

            this.api().columns([6]).every(function () {
                var column = this;
                // console.log(column);
                var select = $("#abandedSelect");
                column.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
            $("#select-agent,#select-customer,#day-select,#incomingSelect,#abandedSelect").material_select();
        }
    });

    switchTable.on('order.dt search.dt', function () {
        switchTable.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('#start-date').val();
            var max = $('#end-date').val();

            //bug id dont know why ! but lets fix
            var maxAddDay = new Date(max);
            maxAddDay.setDate(maxAddDay.getDate() + 1);
            // console.log(max);
            // console.log(maxAddDay);


            var createdAt = data[9]; // Our date column in the table

            if (
                (min == "" || max == "") ||
                (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(maxAddDay))
            ) {
                return true;
            }

            return false;
        }
    );


    $('.select-dropdown').val('');

    getDateRange($('#start-date').attr('min'), $('#start-date').attr('max'));
    displayChartsFunc();


    $('#scroll-table').on('click', function () {

        window.scrollBy(0, 600);
    });

    $('#scroll-graphs').on('click', function () {

        window.scrollBy(0, 1500);
    });


    // Re-draw the table when the a date range filter changes
    $('.date-range-filter').change(function () {
        if ($('#start-date').val() > $('#end-date').val() && $('#start-date').val() !== '' && $('#end-date').val() !== '') {
            alert('תאריכים שגויים');
            $('#start-date').val('');
            $('#end-date').val('');
            return false;
        } else {
            var startDate = $('#start-date').val();
            var endDate = $('#end-date').val();

            getDateRange(startDate, endDate);
            switchTable.draw();
            console.log(switchTable);
        }
    });





    $('#select-agent').on('change', function () {
        var search = [];

        $.each($('#select-agent option:selected'), function () {
            search.push($(this).val());
        });

        search = search.join('|');
        switchTable.column(1).search(search, true, false).draw();
    });

    $('#select-customer').on('change', function () {
        var search = [];

        $.each($('#select-customer option:selected'), function () {
            search.push($(this).val());
        });

        search = search.join('|');
        switchTable.column(3).search(search, true, false).draw();
    });

    $('#day-select').on('change', function () {
        var search = [];

        $.each($('#day-select option:selected'), function () {
            search.push($(this).val());
        });

        search = search.join('|');


        switchTable.column(10).search(search, true, false).draw();
    });

    $('#incomingSelect').on('change', function () {
        var search = [];

        $.each($('#incomingSelect option:selected'), function () {
            search.push($(this).val());
        });

        search = search.join('|');


        switchTable.column(5).search(search, true, false).draw();
    });

    $('#abandedSelect').on('change', function () {
        var search = [];

        $.each($('#abandedSelect option:selected'), function () {
            search.push($(this).val());
        });

        search = search.join('|');


        switchTable.column(6).search(search, true, false).draw();
    });


    function getDateRange(startDate, endDate, agents = null, customers = null) {
        $.ajax({
            type: "GET",
            url: url + 'bydate/' + startDate + '/' + endDate,
            success: function (data) {
                console.log(data);


                var incomingCalls = 0;
                var outComingCalls = 0;
                var countOfStandMax = 0;
                var countOfStandMin = 0;
                var countOfCallsMax = 0;
                var countOfCallMin = 0;
                var abandedCalss = 0;
                var unabendeCalls = 0;
                var calls = data['switchboard'];
                var avgCallsByMin = data['callTimeAvg'];
                var avgStandByByMin = data['standByTimeAvg'];
                var avgCallsPerDay = data['avgCallPerDay'];


                for (var i = 0; i < calls.length; i++) {

                    if (calls[i]['incoming_call'] == 1) {
                        incomingCalls++;
                    } else {
                        outComingCalls++
                    }

                    if (calls[i]['standby_time'] > '00:10:00') {
                        countOfStandMax++;
                    } else {
                        countOfStandMin++;
                    }

                    if (calls[i]['call_time'] > '00:30:00') {
                        countOfCallsMax++;
                    } else {
                        countOfCallMin++;
                    }

                    if(calls[i]['abanded'] == 1){
                        abandedCalss++;
                    }
                    if(calls[i]['abanded'] == 0 && calls[i]['incoming_call'] == 1){
                        unabendeCalls++;
                    }
                }

                var abandedPercent = {

                    animationEnabled: true,
                    title: {
                        text: "אחוזי שיחות ננטשות ונענו"
                    },
                    data: [{
                        type: "doughnut",
                        innerRadius: "40%",
                        showInLegend: true,
                        legendText: "{label}",
                        indexLabel: "{label}: #percent%",
                        dataPoints: [
                            {label: "שיחות ננטשות " + '-' + abandedCalss, y: abandedCalss},
                            {label: "שיחות שנענו " + '-' + unabendeCalls, y: unabendeCalls},
                            // { label: "Stores for Men / Women", y: 1610846 },
                            // { label: "Teenage Specialty Stores", y: 950875 },
                            // { label: "All other outlets", y: 900000 }
                        ]
                    }]

                };

                $("#abandedPercent").CanvasJSChart(abandedPercent);

                var callPercent = {
                    animationEnabled: true,
                    title: {
                        text: "אחוזי שיחות נכנסות יוצאות"
                    },
                    data: [{
                        type: "doughnut",
                        innerRadius: "40%",
                        showInLegend: true,
                        legendText: "{label}",
                        indexLabel: "{label}: #percent%",
                        dataPoints: [
                            {label: "שיחות נכנסות ", y: incomingCalls},
                            {label: "שיחות יוצאות ", y: outComingCalls},
                        ]
                    }]
                };
                $("#callPercent").CanvasJSChart(callPercent);


                var avgTimePercent = {
                    animationEnabled: true,
                    title: {
                        text: "אחוזי זמן המתנה וזמן שיחה"
                    },
                    data: [{
                        type: "doughnut",
                        innerRadius: "40%",
                        showInLegend: true,
                        legendText: "{label}",
                        indexLabel: "{label}: #percent%",
                        dataPoints: [
                            {label: "מעל 10 דקות המתנה ", y: countOfStandMax},
                            {label: " פחות מ 10 דקות המתנה ", y: countOfStandMin},
                            {label: "מעל 30 דקות שיחה", y: countOfCallsMax},
                            {label: "פחות מ 30 דקות שיחה", y: countOfCallMin},
                        ]
                    }]
                };

                $("#avgTimePercent").CanvasJSChart(avgTimePercent);


                var minIsraelDate = israelDate(startDate);
                var maxIsarelDate = israelDate(endDate);



                $('#datesArea').text(` הצגת נתונים כלליים בין תאריכים  ${minIsraelDate} - ${maxIsarelDate}`)
                $('#callTotal').text(`סה"כ שיחות - ${parseInt(calls.length)}`);
                $('#incoming').text(` נכנסות - ${parseInt(incomingCalls)}`);
                $('#outcoming').text(` יוצאות - ${parseInt(outComingCalls)}`);

                $('#avgCallTime').text(`  ממוצע המתנה בדקות -  ${parseInt(avgStandByByMin)}`);
                $('#avgStandTime').text(` ממוצע שיחה בדקות - ${parseInt(avgCallsByMin)}`);

                $('#avgPerDay').text(` ממוצע שיחות ליום -  ${parseInt(avgCallsPerDay)}`);
            }
        });
    }


    function israelDate(date){
        date = new Date(date);
        var dd = date.getDate();
        var mm = date.getMonth() + 1; //January is 0!

        var yyyy = date.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }

        var dateIsrael = dd + '/' + mm + '/' + yyyy;
        return dateIsrael;
    }



    $("#displayGraphs").click(function () {
        displayChartsFunc();
        window.scrollBy(0, 1500);
    });

    function displayChartsFunc() {


        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();

        if(startDate !== "" && endDate == "" || endDate !== "" && startDate == ""){
            alert('תאריכים שגויים');
            $('#start-date').val('');
            $('#end-date').val('');
            return false;
        }

        if(endDate == "" && startDate == ""){
            startDate = $('#start-date').attr('min');
            endDate = $('#start-date').attr('max');
        }

        var dates = [startDate, endDate];
        var agents = [];

        $.each($('#select-agent option:selected'), function () {
            agents.push($(this).val());
        });

        var customers = [];

        $.each($('#select-customer option:selected'), function () {
            customers.push($(this).val());
        });

        var days = [];

        $.each($('#day-select option:selected'), function () {
            days.push($(this).val());
        });

        var dataToGraphs = {
            agents: agents,
            customers: customers,
            days: days,
            dates: dates,
        };

        console.log(dataToGraphs);


        $.ajax({
            type: "GET",
            url: url + 'datagraphs/' + JSON.stringify(dataToGraphs),
            success: function (data) {
                agsId = [];
                cusId =[];

                console.log(data);
                // console.log(data['agents']);
                // console.log(data['agents'][1]['data']);
                // console.log(data['agents'].length);

                for (let i = 0; i < data['agentsId'].length; i++) {
                    agsId.push(data['agentsId'][i]);
                }

                for (let i = 0; i < data['customersId'].length; i++) {
                    cusId.push(data['customersId'][i]);
                }

                 labelsCountCallsAgs = [];
                labelsAvgCallTimeAgs =[];
                labelAvgStandTimeAgs = [];
                labeloutInCallsAgs = [];
                labelOutCallAgs = [];
                labelAbnCallsAgs= [];

                labeloutInCallsCus= [];
                labelOutCallCus = [];
                labelAbnCallCus = [];

                labelCountCallsCustomer = [];
                labelAvgCallTimeCus = [];
                labelAvgStandTimeCus= [];
                //make graph for agent
                for (let i = 0; i < agsId.length; i++) {
                    var indexAgs = agsId[i];
                    // console.log(data['agents'][indexAgs]['data']);
                    var NameAgent = data['agents'][indexAgs]['data']['agent']['agent_name'];
                    var avgStandAgent = data['agents'][indexAgs]['data']['standByTimeAvg'];
                    var avgCallAgent = data['agents'][indexAgs]['data']['callTimeAvg'];
                    var incomingCalls = data['agents'][indexAgs]['data']['incomingCalls'];
                    var outcomingCalls = data['agents'][indexAgs]['data']['outComingCalls'];
                    var abandedCalls = data['agents'][indexAgs]['data']['abandedCalls'];
                    var countCallsAgent = Object.keys(data['agents'][indexAgs]['data']['switchboard']).map(function(key) {
                        return [Number(key), data['agents'][indexAgs]['data']['switchboard'][key]];
                    });

                    // var countCalls = data['agents'][indexAgs]['data']['switchboard'].length;
                    console.log(countCallsAgent);
                    console.log(NameAgent);
                    console.log(avgStandAgent);
                    console.log(avgCallAgent);

                    labelsCountCallsAgs.push( {label: NameAgent+ ' ' + (countCallsAgent.length - abandedCalls), y: (countCallsAgent.length - abandedCalls)});

                    labeloutInCallsAgs.push({label: NameAgent + '-נכנס '+ incomingCalls, y: incomingCalls});
                    labelOutCallAgs.push({label: NameAgent + '-יצא ' + outcomingCalls, y: outcomingCalls});
                    labelAbnCallsAgs.push({label: NameAgent+ '-ננטש ' + abandedCalls, y: abandedCalls});
                    labelsAvgCallTimeAgs.push( {label: NameAgent + ' ' + parseInt(avgCallAgent), y: parseInt(avgCallAgent)});
                    labelAvgStandTimeAgs.push( {label: NameAgent + ' ' + parseInt(avgStandAgent), y: parseInt(avgStandAgent)});
                    console.log(labelsCountCallsAgs);
                    console.log(labelsAvgCallTimeAgs);
                    console.log(labelAvgStandTimeAgs);
                }

                for (let i = 0; i < cusId.length; i++) {
                    var indexCus = cusId[i];
                    console.log(data['customers'][indexCus]['data']);
                    var nameCustomer = data['customers'][indexCus]['data']['customer']['customer_name'];
                    var avgStandCustomer = data['customers'][indexCus]['data']['standByTimeAvg'];
                    var avgCallCustomer = data['customers'][indexCus]['data']['callTimeAvg'];
                    var incomingCalls = data['customers'][indexCus]['data']['incomingCalls'];
                    var outcomingCalls = data['customers'][indexCus]['data']['outComingCalls'];
                    var abandedCalls = data['customers'][indexCus]['data']['abandedCalls'];
                    var countCallsCustomer = Object.keys(data['customers'][indexCus]['data']['switchboard']).map(function(key) {
                        return [Number(key), data['customers'][indexCus]['data']['switchboard'][key]];
                    });


                    labeloutInCallsCus.push({label: nameCustomer + '-נכנס '+ incomingCalls, y: incomingCalls});
                    labelOutCallCus.push({label: nameCustomer + '-יצא ' + outcomingCalls, y: outcomingCalls});
                    labelAbnCallCus.push({label: nameCustomer+ '-ננטש ' + abandedCalls, y: abandedCalls});
                    // labeloutInCallsCus.push({label: nameCustomer + 'נכנס', y: incomingCalls},{label: nameCustomer +'יצא', y: outcomingCalls},{label: nameCustomer + 'ננטש', y: abandedCalls});
                    labelCountCallsCustomer.push( {label: nameCustomer+ ' ' + (countCallsCustomer.length - abandedCalls), y: (countCallsCustomer.length - abandedCalls)});
                    labelAvgCallTimeCus.push( {label: nameCustomer + ' ' + parseInt(avgCallCustomer), y: parseInt(avgCallCustomer)});
                    labelAvgStandTimeCus.push( {label: nameCustomer + ' ' + parseInt(avgStandCustomer), y: parseInt(avgStandCustomer)});

                }

                console.log(labelCountCallsCustomer);
                console.log(labelAvgCallTimeCus);
                console.log(labelAvgStandTimeCus);

                console.log(labelsCountCallsAgs);
                console.log(labelsAvgCallTimeAgs);
                console.log(labelAvgStandTimeAgs);




                var customerInOutCalls = {
                    animationEnabled: true,
                    title: {
                        text: "לקוחות נכנסות יוצאות ננטשות "
                    },
                    data: [{
                        type: "column", //change it to line, area, bar, pie, etc
                        legendText: "לקוחות נכנסות יוצאות ננטשות",
                        showInLegend: true,
                        dataPoints: labeloutInCallsCus
                    },{
                        type: "line", //change it to line, area, bar, pie, etc
                        legendText: "לקוחות  יוצאות ",
                        showInLegend: true,
                        dataPoints: labelOutCallCus
                    },{
                        type: "area", //change it to line, area, bar, pie, etc
                        legendText: "לקוחות   ננטשות",
                        showInLegend: true,
                        dataPoints: labelAbnCallCus
                    },
                    ]

                };





                var customerAmoutCalls = {
                    animationEnabled: true,
                    title: {
                        text: "לקוחות כמות שיחות שהרחשו"
                    },
                    data: [{
                        type: "column", //change it to line, area, bar, pie, etc
                        legendText: "כמות שיחות",
                        showInLegend: true,
                        dataPoints: labelCountCallsCustomer
                    },
                    ]

                };
                var customerAvgCallTime = {
                    animationEnabled: true,
                    title: {
                        text: "לקוחות זמן שיחה ממוצע בדקות"
                    },
                    data: [{
                        type: "column", //change it to line, area, bar, pie, etc
                        legendText: " זמן שיחה בדקות",
                        showInLegend: true,
                        dataPoints: labelAvgCallTimeCus
                    },
                    ]

                };
                var custmoerAvgStandTime = {
                    animationEnabled: true,
                    title: {
                        text: "לקוחות זמן המתנה ממוצע בדקות"
                    },
                    data: [{
                        type: "column", //change it to line, area, bar, pie, etc
                        legendText: " זמן המתנה בדקות",
                        showInLegend: true,
                        dataPoints: labelAvgStandTimeCus
                    },
                    ]

                };








                var agentInOutCalls = {
                    animationEnabled: true,
                    title: {
                        text: "נציגים נכנסות יוצאות ננטשות "
                    },
                    data: [{
                        type: "column", //change it to line, area, bar, pie, etc
                        legendText: "נציגים נכנסות יוצאות ננטשות",
                        showInLegend: true,
                        dataPoints: labeloutInCallsAgs
                    },{
                        type: "line", //change it to line, area, bar, pie, etc
                        legendText: "נציגים  יוצאות ",
                        showInLegend: true,
                        dataPoints: labelOutCallAgs
                    },{
                        type: "area", //change it to line, area, bar, pie, etc
                        legendText: "נציגים   ננטשות",
                        showInLegend: true,
                        dataPoints: labelAbnCallsAgs
                    },
                    ]

                };

                    var agentAmountCalls = {
                        animationEnabled: true,
                        title: {
                            text: "נציגים כמות שיחות שהתרחשו"
                        },
                        data: [{
                            type: "column", //change it to line, area, bar, pie, etc
                            legendText: "כמות שיחות",
                            showInLegend: true,
                            dataPoints: labelsCountCallsAgs
                        },
                        ]

                    };

                var chartAgentsAvgStand = {
                    animationEnabled: true,
                    title: {
                        text: "נציגים זמן המתנה ממוצע בדקות"
                    },
                    data: [{
                        type: "column", //change it to line, area, bar, pie, etc
                        legendText: " זמן המתנה ממוצע בדקות",
                        showInLegend: true,
                        dataPoints: labelAvgStandTimeAgs
                    }
                    ]

                };

                var chartAgentsAvgCall = {
                    animationEnabled: true,
                    title: {
                        text: "נציגים זמן שיחה ממוצע בדקות"
                    },
                    data: [{

                        type: "column", //change it to line, area, bar, pie, etc
                        legendText: " זמן שיחה ממוצע בדקות",
                        showInLegend: true,
                        dataPoints: labelsAvgCallTimeAgs
                    }
                    ]

                };



                $( "#charts-area" ).empty();

                var chartsToDiplay = ` 
                
                 <div class="row">
                   <div class="agentChartArea" style="height: 370px;border:1px solid gray; width: 40%">
                <div id="chartImOutCalls" style="height: 100%; width: 100%;"></div>
            </div>
            <div class="agentChartArea" style="height: 370px;border:1px solid gray; width: 20%">
                <div id="chartAgentsAmountCalls" style="height: 100%; width: 100%;"></div>
            </div>
            <div class="agentChartArea" style="height: 370px;border:1px solid gray;  width: 20%">
                <div id="chartAgentsAvgStand" style="height: 100%; width: 100%;"></div>
            </div>
            <div class="agentChartArea" style="height: 370px;border:1px solid gray;  width: 20%">
                <div id="chartAgentsAvgCall" style="height: 100%; width: 100%;"></div>
            </div>
            </div>


            <div class="row">
            
                     <div class="agentChartArea" style="height: 370px;border:1px solid gray; width: 40%">
                <div id="chartImOutCallsCus" style="height: 100%; width: 100%;"></div>
            </div>
            <div class="customersChartArea" style="height: 370px;border:1px solid gray; width: 20%">
                <div id="chartCustomersAmountCalls" style="height: 100%; width: 100%;"></div>
            </div>
            <div class="customersChartArea" style="height: 370px;border:1px solid gray; width: 20%">
                <div id="chartCustomersAvgStand" style="height: 100%; width: 100%;"></div>
            </div>
            <div class="customersChartArea" style="height: 370px;border:1px solid gray; width: 20%">
                <div id="chartCustomersAvgCall" style="height: 100%; width: 100%;"></div>
            </div>
            </div>
                
                
                `;

                $(chartsToDiplay).appendTo("#charts-area");



                $(".agentChartArea").resizable({
                        create: function (event, ui) {
                            //Create chart.
                            $("#chartImOutCalls").CanvasJSChart(agentInOutCalls);
                            $("#chartAgentsAvgCall").CanvasJSChart(chartAgentsAvgCall);
                                $("#chartAgentsAvgStand").CanvasJSChart(chartAgentsAvgStand);
                              $("#chartAgentsAmountCalls").CanvasJSChart(agentAmountCalls);

                        },
                        resize: function (event, ui) {
                            //Update chart size according to its container size.
                            $("#chartImOutCalls").CanvasJSChart().render();
                            $("#chartAgentsAvgCall").CanvasJSChart().render();
                            $("#chartAgentsAvgStand").CanvasJSChart().render();
                            $("#chartAgentsAmountCalls").CanvasJSChart().render();

                        }
                    });

                $(".customersChartArea").resizable({
                    create: function (event, ui) {
                        //Create chart.
                        $("#chartImOutCallsCus").CanvasJSChart(customerInOutCalls);
                        $("#chartCustomersAmountCalls").CanvasJSChart(customerAmoutCalls);
                        $("#chartCustomersAvgCall").CanvasJSChart(customerAvgCallTime);
                        $("#chartCustomersAvgStand").CanvasJSChart(custmoerAvgStandTime);
                    },
                    resize: function (event, ui) {
                        //Update chart size according to its container size.

                        $("#chartImOutCallsCus").CanvasJSChart.render();
                        $("#chartCustomersAmountCalls").CanvasJSChart.render();
                        $("#chartCustomersAvgCall").CanvasJSChart.render();
                        $("#chartCustomersAvgStand").CanvasJSChart.render();
                    }
                });


            }
        });




    }



});


