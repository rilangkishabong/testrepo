$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btnlvls").click(function(e) {
        e.preventDefault();
        var reqid = $(this).data('id');
        $.ajax({
            type: "post",
            url: "ChgLeaveStat",
            data: { data: reqid },
            success: function(response) {
                var op1a = '';
                op1a += "<option value=''>Change Leave Status</option>";
                for (var i = 0; i < response.lvstatus.length; i++) {
                    op1a += '<option value="' + response.lvstatus[i].id + '" ' + (response.lvstatus[i].id == response.reqdatas[0].leave_stats_id ? ' selected ' : '') + '>' + response.lvstatus[i].leave_status + '</option>';
                }
                $("#lvstat").html(op1a);
                $("#remk").val(response.reqdatas[0].remks);
                $("#empnameid").val(response.reqdatas[0].emp_name_id);
                $("#leavid").val(reqid);
            }
        });
    });

    $("#leavestatsform").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            //url: "school-addstudent" + '/' + globPK,
            url: "UpdateLeaveData",
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