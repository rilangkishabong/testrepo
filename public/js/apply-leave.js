$(document).ready(function() {
    $("#dtfrm").change(function(e) {
        e.preventDefault();
        var dt1 = $("#dtfrm").val();
        $('#dtto').attr('min', dt1);
        $('#dtto').val(dt1);
        var dt2 = $("#dtto").val();
        dt1 = new Date(dt1);
        dt2 = new Date(dt2);
        var diff = new Date(dt1 - dt2);
        var days = diff / 1000 / 60 / 60 / 24;
        days = days + 1;
        $("#nod").val(days);
        var hd = "";
        if (days > 1) {
            $("#shftime").find("option[value='Half day']").prop('disabled', true);
        } else {
            $("#shftime").find("option[value='Half day']").prop('disabled', false);
        }
    });
    $('#dtto').change(function(e) {
        e.preventDefault();
        var dt1 = $("#dtfrm").val();
        $('#dtto').attr('min', dt1);
        //$('#dtto').val(dt1);
        var dt2 = $("#dtto").val();
        dt1 = new Date(dt1);
        dt2 = new Date(dt2);
        var diff = new Date(dt2 - dt1);
        var days = diff / 1000 / 60 / 60 / 24;
        days = days + 1;
        $("#nod").val(days);
        var nodd = $("#nod").val();
        var hd = "";
        if (days > 1) {
            $("#shftime").find("option[value='Half day']").prop('disabled', true);
        } else {
            $("#shftime").find("option[value='Half day']").prop('disabled', false);
        }
    });
});