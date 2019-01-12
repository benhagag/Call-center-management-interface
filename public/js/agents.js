var url = window.location.href;
$(document).ready(function () {

    $('#agents').DataTable({
        "order": [[1, "asc"]],
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
        }


    });


    $(".agent-name").click(function () {
        $( "#agent-data" ).empty();
        var id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: url + '/' + id,
            success: function (agent) {
                console.log(agent);
                var agentName = agent['agent']['agent_name'];
                var extension = agent['agent']['extension_number'];
                var agentCalls = agent['switchboard'];
                var avgCallsByMin = agent['callTimeAvg'];
                var avgStandByByMin = agent['standByTimeAvg'];
                var avgCallsPerDay = agent['avgCallPerDay'];
                var incomingCalls = 0;
                var outComingCalls = 0;


                for (var i = 0; i < agentCalls.length; i++) {

                    if(agentCalls[i]['incoming_call'] == 1){
                        incomingCalls++;
                    }
                else{
                    outComingCalls++
                    }
                }


                var agentToDisplay = `
             <h2 id="data-name">שם: ${agentName} </h2>
        <h2 id="data-extension">מס' שלוחה: ${extension}</h2>
        <p id ="data-dates-min">תחילת עבודה: ${agent['minDate']}</p>
         <p id ="data-dates-max">תאריך אחרון של ביצוע שיחה: ${agent['maxDate']}</p>
        <p id ="data-calls-amount">כמות שיחות סה"כ: ${agentCalls.length}</p>
        <p id ="data-calls-incoming">שיחות נכנסות: ${incomingCalls}</p>
        <p id ="data-calls-outcoming">שיחות יוצואת: ${outComingCalls}</p>
        <p id ="data-standby-time">ממוצע המתנה לשיחה בדקות: ${avgStandByByMin}</p>
        <p id ="data-call-time">ממוצע זמן שיחה בדקות : ${avgCallsByMin}</p>
        <p id ="data-avg-call-per-day">ממוצע שיחות ביום : ${avgCallsPerDay}</p>
        `;

                $( "#agent-data" ).append(agentToDisplay);

            }
        });
    });


    $("#switchboard-range").click(function () {
        $( "#switchboard-range-data" ).empty();
        var startDate = $("#start-date").val();
        var endDate = $("#end-date").val();
        var agentId = $("#select-agent").val();


        if(startDate > endDate){
            alert('הנתונים שהזנת שגויים');
            return false;
        }

        console.log(startDate);
        console.log(endDate);
        console.log(agentId);


        $.ajax({
            type: "GET",
            url: url + '/' + agentId + '/' + startDate + '/' + endDate,
            success: function (data) {
                console.log(data);

                var agentName = data['agent']['agent_name'];
                var extension = data['agent']['extension_number'];
                var incomingCalls = 0;
                var outComingCalls = 0;
                var calls = data['switchboard'];
                var avgCallsByMin = data['callTimeAvg'];
                var avgStandByByMin = data['standByTimeAvg'];
                var avgCallsPerDay = data['avgCallPerDay'];



                for (var i = 0; i < calls.length; i++) {

                    if(calls[i]['incoming_call'] == 1){
                        incomingCalls++;
                    }
                    else{
                        outComingCalls++
                    }
                }


                var dataToDisplay = `
        <h2 id="data-range-agent-name">שם נציג :  ${agentName}</h2>
        <p id="data-range-agent-ext"> מספר שלוחה : ${extension}</p>
        <p id ="data-dates-min">מתאריך : ${data['minDate']}</p>
         <p id ="data-dates-max">עד תאריך: ${data['maxDate']}</p>
        <p id ="data-calls-amount">כמות שיחות סה"כ: ${calls.length}</p>
        <p id ="data-calls-incoming">שיחות נכנסות: ${incomingCalls}</p>
        <p id ="data-calls-outcoming">שיחות יוצואת: ${outComingCalls}</p>
        <p id ="data-standby-time">ממוצע המתנה לשיחה בדקות: ${avgStandByByMin}</p>
        <p id ="data-call-time">ממוצע זמן שיחה בדקות : ${avgCallsByMin}</p>
        <p id ="data-avg-call-per-day">ממוצע שיחות ביום : ${avgCallsPerDay}</p>
        <p id="best-day-range">יום בשבוע הכי חזר בזמן זה:  ${data['bestDayInRange']} </p>
        `;

                $( "#switchboard-range-data" ).append(dataToDisplay);

            }
        });


    });




});


