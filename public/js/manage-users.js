$(document).ready(function() {
    $("#officenamex").change(function(e) {
        e.preventDefault();
        var offid = $("#officenamex").val();
        $.ajax({
            type: "post",
            url: "GetDepartment",
            data: { offid: offid },
            success: function(response) {
                console.log(response);

                var opdep = ''
                opdep += '<option value="">Select Department</option>';
                for (var i = 0; i < response.depdatas.length; i++) {
                    opdep += '<option value="' + response.depdatas[i].id + '" ' + (response.depdatas[i].id == response.depuser[0].dept_id ? ' selected ' : '') + '>' + response.depdatas[i].dept_name + '</option>';
                }
                $("#depnamex").html(opdep);
            }
        });
    });
    $(".editacc").click(function(e) {
        e.preventDefault();
        var usrx = $(this).data('id');
        $("#usridd").val(usrx);
    });
    $("#updateuserinfos").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "UpdateUserType",
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
    $(".editusrdata").click(function(e) {
        e.preventDefault();
        var idx = $(this).data('id');
        $.ajax({
            type: "post",
            url: "ReqUserDatas",
            data: { idx: idx },
            success: function(response) {
                var off_opt = '';
                var dept_opt = '';
                for (var i = 0; i < response.offices.length; i++) {
                    off_opt += '<option value="' + response.offices[i].id + '" ' + (response.offices[i].id == response.userdatas[0].office_id ? ' selected ' : '') + '>' + response.offices[i].office_name + '</option>';
                }
                $("#usr_officename").html(off_opt);

                for (var i = 0; i < response.depts.length; i++) {
                    dept_opt += '<option value="' + response.depts[i].id + '" ' + (response.depts[i].id == response.userdatas[0].dept_id ? ' selected ' : '') + '>' + response.depts[i].dept_name + '</option>';
                }
                $("#usr_depname").html(dept_opt);

                if (response.userdatas[0].sex == "Male") {
                    $("#usr_gend").find("option[value='Male']").prop('selected', true);
                    $("#usr_gend").find("option[value='Female']").prop('selected', false);
                } else if (response.userdatas[0].sex == "Female") {
                    $("#usr_gend").find("option[value='Female']").prop('selected', true);
                    $("#usr_gend").find("option[value='Male']").prop('selected', false);
                }

                $("#usr_desg").val(response.userdatas[0].desg);
                $("#usr_uname").val(response.userdatas[0].name);
                $("#usr_umail").val(response.userdatas[0].email);
                $("#usr_empid").val(response.userdatas[0].emp_id);
            }
        });
    });

    $("#usr_officename").change(function(e) {
        e.preventDefault();
        var offid = $("#usr_officename").val();
        $.ajax({
            type: "post",
            url: "GetDepartment",
            data: { offid: offid },
            success: function(response) {
                var opdep = ''
                opdep += '<option value="">Select Department</option>';
                for (var i = 0; i < response.depdatas.length; i++) {
                    opdep += '<option value="' + response.depdatas[i].id + '" ' + (response.depdatas[i].id == response.depuser[0].dept_id ? ' selected ' : '') + '>' + response.depdatas[i].dept_name + '</option>';
                }
                $("#usr_depname").html(opdep);
            }
        });
    });

    $("#UpdUserDataFormx").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            //url: "school-addstudent" + '/' + globPK,
            url: "UpdateUserData",
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