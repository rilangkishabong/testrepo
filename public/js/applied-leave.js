$(document).ready(function() {
    $("#from_upd").change(function(e) {
        e.preventDefault();
        var dt1 = $("#from_upd").val();
        $('#till_upd').attr('min', dt1);
        $('#till_upd').val(dt1);
        var dt2 = $("#till_upd").val();
        dt1 = new Date(dt1);
        dt2 = new Date(dt2);
        var diff = new Date(dt1 - dt2);
        var days = diff / 1000 / 60 / 60 / 24;
        days = days + 1;
        $("#nod").val(days);
        var hd = "";
        if (days > 1) {
            $("#shift_upd").find("option[value='Half day']").prop('disabled', true);
        } else {
            $("#shift_upd").find("option[value='Half day']").prop('disabled', false);
        }
    });
    $('#till_upd').change(function(e) {
        e.preventDefault();
        var dt1 = $("#from_upd").val();
        $('#till_upd').attr('min', dt1);
        //$('#till_upd').val(dt1);
        var dt2 = $("#till_upd").val();
        dt1 = new Date(dt1);
        dt2 = new Date(dt2);
        var diff = new Date(dt2 - dt1);
        var days = diff / 1000 / 60 / 60 / 24;
        days = days + 1;
        $("#nod").val(days);
        var nodd = $("#nod").val();
        var hd = "";
        if (days > 1) {
            $("#shift_upd").find("option[value='Half day']").prop('disabled', true);
        } else {
            $("#shift_upd").find("option[value='Half day']").prop('disabled', false);
        }
    });
    $(".edtleav").on("click", function() {
        var id = $(this).data("id");
        $.ajax({
            type: "post",
            url: "GetAppliedLeave",
            data: { req: id },
            success: function(response) {
                console.log(response.ReqLv.shift_time);
                $("#from_upd").val(response.ReqLv.date_from);
                $("#till_upd").val(response.ReqLv.date_to);
                $("#nod").val(response.ReqLv.no_of_days);
                $("#reason_upd").val(response.ReqLv.reason);
                $("#leavid").val(response.ReqLv.id);
                $("#shift_upd").val(response.ReqLv.shift_time);
                $("#modal-leave").modal('show');
            }
        });
    });
    $(".cancleav").on("click", function() {
        if (confirm('Are you sure you want to cancel?')) {
            var id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "CancelAppliedLeave",
                data: { req: id },
                success: function(response) {
                    alert(response.success);
                    location.reload();
                },
                error: function(response) {
                    alert("ERROR");
                }
            });
        } else {
            return false;
        }

    });
    $("#updleavform").on('submit', function(e) {
        $.ajax({
            type: 'POST',
            url: "UpdateAppliedLeave",
            dataType: "JSON",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                alert("Data updated successfully");
                location.reload();
            },
            error: function(response) {
                alert("ERROR");
            }
        });
    });

});
