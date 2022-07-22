$(document).ready(function() {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
        // var today = new Date();
        // var dd = today.getDate();
        // var mm = today.getMonth() + 1; //January is 0 so need to add 1 to make it 1!
        // var yyyy = today.getFullYear();
        // if (dd < 10) {
        //     dd = '0' + dd
        // }
        // if (mm < 10) {
        //     mm = '0' + mm
        // }
        // today = yyyy + '-' + mm + '-' + dd;
        // $('#empdatefr').attr('min', today);
        // $('#empdateto').attr('min', today);

    $("#empdatefr").change(function(e) {
        e.preventDefault();

        var dt1 = new Date($("#empdatefr").val());
        var dt2 = new Date($("#empdateto").val());
        var diff = new Date(dt2 - dt1);
        var days = diff / 1000 / 60 / 60 / 24;
        days = days + 1;
        $("#empnod").val(days);
        $('#empdateto').attr('min', $("#empdatefr").val());
    });
    $("#empdatefr_upd").change(function(e) {
        e.preventDefault();

        var dt1 = new Date($("#empdatefr_upd").val());
        var dt2 = new Date($("#empdateto_upd").val());
        var diff = new Date(dt2 - dt1);
        var days = diff / 1000 / 60 / 60 / 24;
        days = days + 1;
        $("#empnod_upd").val(days);
        $('#empdateto_upd').attr('min', $("#empdatefr_upd").val());
    });
    $("#empdateto").change(function(e) {
        e.preventDefault();
        var dt1 = new Date($("#empdatefr").val());
        var dt2 = new Date($("#empdateto").val());
        var diff = new Date(dt2 - dt1);
        var days = diff / 1000 / 60 / 60 / 24;
        days = days + 1;
        $("#empnod").val(days);
    });
    $("#empdateto_upd").change(function(e) {
        e.preventDefault();
        var dt1 = new Date($("#empdatefr_upd").val());
        var dt2 = new Date($("#empdateto_upd").val());
        var diff = new Date(dt2 - dt1);
        var days = diff / 1000 / 60 / 60 / 24;
        days = days + 1;
        $("#empnod_upd").val(days);
    });
    $("#emptime").click(function(e) {
        e.preventDefault();
        var dayy = $("#empnod").val();
        if (dayy > 1) {
            $("#emptime").find("option[value='Half day']").prop('disabled', true);
        } else {
            $("#emptime").find("option[value='Half day']").prop('disabled', false);
        }
    });
    $("#emptime_upd").click(function(e) {
        e.preventDefault();
        var dayy = $("#empnod_upd").val();
        if (dayy > 1) {
            $("#emptime_upd").find("option[value='Half day']").prop('disabled', true);
        } else {
            $("#emptime_upd").find("option[value='Half day']").prop('disabled', false);
        }
    });
    $(".btndeput").click(function(e) {
        e.preventDefault();
        var depid = $(this).data('id');

        $.ajax({
            type: "post",
            url: "GetTourDatas",
            data: { depid: depid },
            success: function(response) {
                console.log(response);
                $("#empid_upd").val(response.allusers[0].emp_id);
                var op1a = '';
                var op1b = '';
                var optns = '';


                $("#empname_upd").val(response.depute_staf_upd[0].name);
                //$("#emptours_upd").html(op1a);
                optns = '<option value="">Select Tour</option>';
                for (var i1 = 0; i1 < response.tours.length; i1++) {
                    optns += '<option value="' + response.tours[i1].id + '" ' + (response.tours[i1].id == response.depute_staf_upd[0].dep_tour_id ? ' selected ' : '') + '>' + response.tours[i1].tour_prog + '</option>';
                }
                $("#emptours_upd").html(optns);
                $("#prid").val(response.depute_staf_upd[0].id);

                $("#empid_upd").val(response.depute_staf_upd[0].emp_id);
                $("#empdesg_upd").val(response.depute_staf_upd[0].desg);
                $("#empdep_upd").val(response.depute_staf_upd[0].dept_name);
                $("#empdepid_upd").val(response.depute_staf_upd[0].did);
                $("#emptour_upd").val(response.depute_staf_upd[0].tour_prog);
                $("#empspectour_upd").val(response.depute_staf_upd[0].dep_desc);
                $("#empreason_upd").val(response.depute_staf_upd[0].dep_reason);
                $("#emplocatn_upd").val(response.depute_staf_upd[0].dep_locatn);
                $("#empdatefr_upd").val(response.depute_staf_upd[0].dep_date_from);
                $("#empdateto_upd").val(response.depute_staf_upd[0].dep_date_to);
                $("#emp_date_upd").val(response.depute_staf_upd[0].date_posted);
                //date_posted
                op1b += "<option value=''>Select Shift</option>";
                op1b += "<option value='Half day'>Half Day</option>";
                op1b += "<option value='Full day'>Full Day</option>";
                $("#emptime_upd").html(op1b);

                if (response.depute_staf_upd[0].shift_time == "Half day") {
                    $("#emptime_upd").find("option[value='Half day']").prop('selected', true);
                    $("#emptime_upd").find("option[value='Full day']").prop('selected', false);
                } else {
                    $("#emptime_upd").find("option[value='Full day']").prop('selected', true);
                    $("#emptime_upd").find("option[value='Half day']").prop('selected', false);
                }
                //select.options[select.selectedIndex].setAttribute('selected');

                $("#empnod_upd").val(response.depute_staf_upd[0].dep_no_of_days);
            }
        });
    });

    $("#empname").change(function(e) {
        e.preventDefault();
        var usr = $("#empname").val();
        $.ajax({
            type: "post",
            url: "GetUserDatas",
            data: { usr: usr },
            success: function(response) {
                //empdepid
                $("#empids").val(response.usrs[0].emp_id);
                $("#empdesg").val(response.usrs[0].desg);
                $("#empdep").val(response.dept[0].dept_name);
                $("#empdepid").val(response.dept[0].id);
            }
        });
    });

    $("#request_tourupdateform").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "UpdateTourDatax",
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

    $(".btndeputaccept").click(function(e) {
        e.preventDefault();
        var myid = $(this).data("id");
        $.ajax({
            type: "post",
            url: "UpdateTourStatus",
            data: { myid: myid },
            success: function(response) {

                alert("Status Updated Successfully");
                location.reload();
            },
            error: function(response) {
                alert("Error");
            }
        });
    });

    $(".btnchgstat").click(function(e) {
        e.preventDefault();
        var btnid = $(this).data('id');
        $("#tourid").val(btnid);
        $.ajax({
            type: "post",
            url: "GetTourStatus",
            data: { btnid: btnid },
            success: function(response) {
                var opstat = '';
                opstat = '<option value="">Select Tour</option>';
                for (var i1 = 0; i1 < response.tourstat.length; i1++) {
                    opstat += '<option value="' + response.tourstat[i1].id + '" ' + (response.tourstat[i1].id == response.seltour[0].dep_status ? ' selected ' : '') + '>' + response.tourstat[i1].tour_status + '</option>';
                }
                $("#tourstat").html(opstat);
                $("#empidxa").val(response.seltour[0].dep_emp_name_id);
            }
        });
    });

    $("#TourStatForm").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "UpdateTourStatus",
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