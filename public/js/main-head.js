$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#tableID').DataTable({
        dom: 'lBfrtip',
        buttons: [
            'excel', 'csv', 'pdf', 'copy'
        ],
    });
    // $('#tableID').DataTable();
    $('#selemployees').on('change', function() {
        table.columns(1).search(this.value).draw();
    });
    $('#selleavetype').on('change', function() {
        table.columns(7).search(this.value).draw();
    });
    $('#selyear').on('change', function() {
        table.columns(11).search(this.value).draw();
    });
    $('#selmonth').on('change', function() {
        table.columns(11).search(this.value).draw();
    });
    $('#selemp').on('change', function() {
        table.columns(0).search(this.value).draw();
    });
    $('#selyr').on('change', function() {
        table.columns(2).search(this.value).draw();
    });
    $('#selmnt').on('change', function() {
        table.columns(2).search(this.value).draw();
    });
    $('#sellvtype').on('change', function() {
        table.columns(2).search(this.value).draw();
    });
    var table_acti = $('#table_acti').DataTable({
        dom: 'lBfrtip',
        buttons: [
            'excel'
        ],
    });
    var usrid = '';
    $("#mydetailss").click(function(e) {
        e.preventDefault();
        var reqid = $(this).data('id');
        usrid = reqid;
        var op1 = '';
        var opdep = '';
        var genop = '';
        $.ajax({
            type: "post",
            url: "GetOffice",
            data: { reqid: reqid },
            success: function(response) {
                //alert(response.officeuser[0].sex);
                if (response.officeuser[0].sex == "Male") {
                    $("#gend").find("option[value='Male']").prop('selected', true);
                    $("#gend").find("option[value='Female']").prop('selected', false);
                } else if (response.officedatas[0].sex == "Female") {
                    $("#gend").find("option[value='Female']").prop('selected', true);
                    $("#gend").find("option[value='Male']").prop('selected', false);
                }
                op1 += '<option value="">Select Office</option>';
                for (var i = 0; i < response.officedatas.length; i++) {
                    op1 += '<option value="' + response.officedatas[i].id + '" ' + (response.officedatas[i].id == response.officeuser[0].office_id ? ' selected ' : '') + '>' + response.officedatas[i].office_name + '</option>';
                }
                $("#officename").html(op1);
                opdep += '<option value="">Select Department</option>';
                for (var i = 0; i < response.depdatas.length; i++) {
                    opdep += '<option value="' + response.depdatas[i].id + '" ' + (response.depdatas[i].id == response.depuser[0].dept_id ? ' selected ' : '') + '>' + response.depdatas[i].dept_name + '</option>';
                }
                $("#depname").html(opdep);
            },
            error: function(response) {
                alert("ERROR");
            }
        });
    });

    $("#officename").change(function(e) {
        e.preventDefault();
        var offid = $("#officename").val();
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
                $("#depname").html(opdep);
            }
        });
    });
    $("#UpdUserForm").on('submit', function(e) {
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