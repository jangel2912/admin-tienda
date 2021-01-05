$(document).ready(function(){
    $("#addHours").click(function(){
        $("#AddHoursForm").show();
    });

    $(function () {
        $('#datetimepicker-from, #datetimepicker-to').datetimepicker({
            format: 'LT'
        });
    });

    $(".editSchedule").click(function(e){
        e.preventDefault();
        var url = $(this).prop("href");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'url': url,
            'method': 'GET',
            'dataType': 'json',
            success: function(data) {
                $("#AddHoursForm").show();
                $("#datetimepicker-from").val(moment(data.open_time, moment.HTML5_FMT.TIME_SECONDS).format(moment.HTML5_FMT.TIME));
                $("#datetimepicker-to").val(moment(data.close_time, moment.HTML5_FMT.TIME_SECONDS).format(moment.HTML5_FMT.TIME));
                
                $("#sunday").prop("checked", data.sunday);
                $("#monday").prop("checked", data.monday);
                $("#tuesday").prop("checked", data.tuesday);
                $("#wednesday").prop("checked", data.wednesday);
                $("#thursday").prop("checked", data.thursday);
                $("#friday").prop("checked", data.friday);
                $("#saturday").prop("saturday", data.friday);

                $("#scheduleId").val(data.id);

            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus + " " + errorThrown);
            }
        });
    });

    $("#addDayServicesDate").click(function(e){
        e.preventDefault();
        //Hide error box
        $("#errorMessages").css("display", "none");
        //Define week dates array
        var selectedDates = [];
        $.each($("input[type='checkbox']:checked"), function(index, element){
            selectedDates.push($(this).val());
        });
        //Validate
        var from = moment($('#datetimepicker-from').val(), "LT");
        var to = moment($('#datetimepicker-to').val(), "LT");
        if(selectedDates.length > 0 && from.isBefore(to)){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'url': $("#AddHoursForm").prop("action"),
                'method': 'POST',
                'dataType': 'json',
                'data' : {
                    from: from.format("HH:mm"),
                    to: to.format("HH:mm"),
                    dates: selectedDates,
                    id: $("#scheduleId").val()
                },
                success: function(data){
                    location.href = "/admin/settings/schedule";
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus + " " + errorThrown);
                }
            });
        }
        else {
            $("#errorMessages").css("display", "block");
        }
    });

});