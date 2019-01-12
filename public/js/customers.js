var url = window.location.href;
$(document).ready(function () {
    $('#customers').DataTable({
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

    $(".customer-name").click(function () {
        var id = $(this).data('id');
        $( "#customer-data" ).empty();

        $.ajax({
            type: "GET",
            url: url + '/' + id,
            success: function (customer) {
                console.log(customer);
                var custםmerName = customer['customer']['customer_name'];
                var phoneNumber = customer['customer']['phone_number'];
                var customerCalls = customer['switchboard'];
                var AvgCallsByMin = customer['callTimeAvg'];
                var AvgStandByByMin = customer['standByTimeAvg'];
                var avgCallsPerDay = customer['avgCallPerDay'];
                var incomingCalls = 0;
                var outComingCalls = 0;


                for (var i = 0; i < customerCalls.length; i++) {
                    if(customerCalls[i]['incoming_call'] == 1){
                        incomingCalls++;
                    }
                    else{
                        outComingCalls++
                    }
                }


                var customerToDisplay = `
             <h2 id="data-name">שם: ${custםmerName} </h2>
        <h2 id="data-extension">מס' טלפון: ${phoneNumber}</h2>
        <p id ="data-dates-min">תחילת עבודה: ${customer['minDate']}</p>
         <p id ="data-dates-max">תאריך אחרון של ביצוע שיחה: ${customer['maxDate']}</p>
        <p id ="data-calls-amount">כמות שיחות סה"כ: ${customerCalls.length}</p>
        <p id ="data-calls-incoming">שיחות נכנסות: ${incomingCalls}</p>
        <p id ="data-calls-outcoming">שיחות יוצואת: ${outComingCalls}</p>
        <p id ="data-standby-time">ממוצע המתנה לשיחה בדקות: ${AvgStandByByMin}</p>
        <p id ="data-call-time">ממוצע זמן שיחה בדקות : ${AvgCallsByMin}</p>
        <p id ="data-avg-call-per-day">ממוצע שיחות ביום : ${avgCallsPerDay}</p>
        `;

                $( "#customer-data" ).append(customerToDisplay);

            }
        });
    });




    $("#switchboard-range").click(function () {
        $( "#switchboard-range-data" ).empty();
        var startDate = $("#start-date").val();
        var endDate = $("#end-date").val();
        var customerId = $("#select-customer").val();


        if(startDate > endDate){
            alert('הנתונים שהזנת שגויים');
            return false;
        }

        console.log(startDate);
        console.log(endDate);
        console.log(customerId);


        $.ajax({
            type: "GET",
            url: url + '/' + customerId + '/' + startDate + '/' + endDate,
            success: function (data) {
                console.log(data);

                var customerName = data['customer']['customer_name'];
                var phoneNumber = data['customer']['phone_number'];
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
        <h2 id="data-range-agent-name">שם לקוח :  ${customerName}</h2>
        <p id="data-range-agent-ext"> מספר טלפון : ${phoneNumber}</p>
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


