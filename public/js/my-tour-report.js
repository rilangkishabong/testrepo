$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
    $("#trfare_exp").keyup(function(e) {
        var smallw = parseInt($("#trfare_exp").val() == "" ? 0 : $("#trfare_exp").val()) +
            parseInt($("#lodgfare_exp").val() == "" ? 0 : $("#lodgfare_exp").val()) +
            parseInt($("#other_exp_exp").val() == "" ? 0 : $("#other_exp_exp").val()) +
            parseInt($("#dallw_exp").val() == "" ? 0 : $("#dallw_exp").val());
        $("#allw_tot").val(smallw);
    });
    $("#lodgfare_exp").keyup(function(e) {
        var smallw = parseInt($("#trfare_exp").val() == "" ? 0 : $("#trfare_exp").val()) +
            parseInt($("#lodgfare_exp").val() == "" ? 0 : $("#lodgfare_exp").val()) +
            parseInt($("#other_exp_exp").val() == "" ? 0 : $("#other_exp_exp").val()) +
            parseInt($("#dallw_exp").val() == "" ? 0 : $("#dallw_exp").val());
        $("#allw_tot").val(smallw);
    });
    $("#other_exp_exp").keyup(function(e) {
        var smallw = parseInt($("#trfare_exp").val() == "" ? 0 : $("#trfare_exp").val()) +
            parseInt($("#lodgfare_exp").val() == "" ? 0 : $("#lodgfare_exp").val()) +
            parseInt($("#other_exp_exp").val() == "" ? 0 : $("#other_exp_exp").val()) +
            parseInt($("#dallw_exp").val() == "" ? 0 : $("#dallw_exp").val());
        $("#allw_tot").val(smallw);
    });
    $("#dallw_exp").keyup(function(e) {
        var smallw = parseInt($("#trfare_exp").val() == "" ? 0 : $("#trfare_exp").val()) +
            parseInt($("#lodgfare_exp").val() == "" ? 0 : $("#lodgfare_exp").val()) +
            parseInt($("#other_exp_exp").val() == "" ? 0 : $("#other_exp_exp").val()) +
            parseInt($("#dallw_exp").val() == "" ? 0 : $("#dallw_exp").val());
        $("#allw_tot").val(smallw);
    });
    $("#mileage").click(function(e) {
        sel_mile = $("#mileage").val();
        if (sel_mile == "Pool Transport" || sel_mile == "Alloted Vehicle") {
            $("trfare").val('');
            $("trfare_exp").val('');
            $("#trfare").removeAttr('required'); //
            $("#trfare_exp").removeAttr('required');
            $("#fortrans").hide();
        } else {
            $("#trfare").prop("required", true);
            $("#trfare_exp").prop("required", true);
            $("#fortrans").show();
        }
    });

    function dateconv1(dtx1) {
        dtx1 = new Date(dtx1);
        var dd = dtx1.getDate();
        var mm = dtx1.getMonth() + 1; //January is 0 so need to add 1 to make it 1!
        var yyyy = dtx1.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        dtx1 = yyyy + '-' + mm + '-' + dd;
        //alert(dtx1);
        return dtx1;
    }

    function dateconv2(dtx2) {
        dtx2 = new Date(dtx2);
        var dd = dtx2.getDate();
        var mm = dtx2.getMonth() + 1; //January is 0 so need to add 1 to make it 1!
        var yyyy = dtx2.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        dtx2 = yyyy + '-' + mm + '-' + dd;
        return dtx2;
    }
    $(".btntr_rept").click(function(e) {
        e.preventDefault();
        var reqid = $(this).data('id');
        $("#dep_id").val(reqid);

        $.ajax({
            type: "post",
            url: "CheckIfTourIsFiled",
            data: { reqid: reqid },
            success: function(response) {
                if (response.avl > 0) {
                    alert("You already submitted report for this tour");
                } else {
                    $.ajax({
                        type: "post",
                        url: "GetDeputDates",
                        data: { reqid: reqid },
                        success: function(response) {
                            var nod = response.reqdates[0].dep_no_of_days;
                            var dt1 = dateconv1(response.reqdates[0].dep_date_from);
                            var dt2 = dateconv2(response.reqdates[0].dep_date_to);
                            // $('#depdate').attr('min', dt1);
                            // $('#depdate').attr('max', dt2);
                            $('#depdate').val(response.reqdates[0].dep_date_from);
                            $('#arridate').val(response.reqdates[0].dep_date_to);
                            // $('#arridate').attr('min', dt1);
                            // $('#arridate').attr('max', dt2);
                            $("#nodays").val(nod);
                            $('#modal-tour_report').modal('toggle');
                        },
                        error: function(response) {
                            alert("Error!");
                        }
                    });
                }
            },
            error: function(response) {
                alert("Error!");
            }
        });

    });

    $(".btntr_rept_edit").click(function(e) {
        e.preventDefault();
        var rep_id = $(this).data('id');
        $("#tid").val(rep_id);
        $("#tr_att1_amt").hide();
        $("#tr_att1").show();
        $("#tr_att1_dwn").hide();
        $("#tr_att2_amt").hide();
        $("#tr_att2").show();
        $("#tr_att2_dwn").hide();
        $("#tr_att3_amt").hide();
        $("#tr_att3").show();
        $("#tr_att3_dwn").hide();
        $("#tr_att4_amt").hide();
        $("#tr_att4").show();
        $("#tr_att4_dwn").hide();

        function monthDiff(d1, d2) {
            var months;
            months = (d2.getFullYear() - d1.getFullYear()) * 12;
            months -= d1.getMonth();
            months += d2.getMonth();
            return months <= 0 ? 0 : months;
        }
        var reqid = $(this).data('id');
        $("#dep_id_upd").val(reqid);
        $.ajax({
            type: "post",
            url: "EditMyTourReport",
            data: { reqid: reqid },
            success: function(response) {
                console.log(response);
                if (response.reqdets == null) {
                    alert("You haven't upload anything for this tour");
                } else {
                    var mdf = monthDiff(new Date(response.reqdets.tr_departure_dt), new Date(response.reqdets.tr_arrival_dt));
                    $("#adv_exp_upd").val(response.reqdets.tr_adv_allw);
                    $("#depdate1_upd").val(response.reqdets.tr_departure_dt);
                    $("#deptime1_upd").val(response.reqdets.tr_departure_tm);
                    $("#arridate2_upd").val(response.reqdets.tr_arrival_dt);
                    $("#arritime2_upd").val(response.reqdets.tr_arrival_tm);
                    $("#originpt1_upd").val(response.reqdets.tr_pt_of_origin1);
                    $("#destinatnpt1_upd").val(response.reqdets.tr_pt_of_destination1);
                    $("#originpt2_upd").val(response.reqdets.tr_pt_of_origin2);
                    $("#destinatnpt2_upd").val(response.reqdets.tr_pt_of_destination2);
                    $("#nodays_upd").val(response.reqdets.tr_no_of_days);
                    $("#jr_type_upd").val(response.reqdets.jr_type);
                    $("#trfare_exp_upd").val(response.reqdets.tr_travel_amt);
                    $("#lodgfare_exp_upd").val(response.reqdets.tr_lodg_amt);
                    $("#dallw_exp_upd").val(response.reqdets.tr_da_amt);
                    $("#other_exp_exp_upd").val(response.reqdets.tr_other_amt);
                    $("#travelmode_upd").val(response.reqdets.tr_travel_mode);
                    $("#tot_allw_upd").val(response.reqsum);
                    //
                    // var optna = '';
                    // optna += '<option value="">Select Travel Mode</option>';
                    // optna += '<option value="Road">Road</option>';
                    // optna += '<option value="Air">Air</option>';
                    // optna += '<option value="Rail">Rail</option>';
                    // $("#travelmode_upd").html(optna);
                    // if (response.reqdets.tr_travel_mode == "Road") {
                    //     $("#travelmode_upd").find("option[value='Road']").prop('selected', true);
                    //     $("#travelmode_upd").find("option[value='Air']").prop('selected', false);
                    //     $("#travelmode_upd").find("option[value='Rail']").prop('selected', false);
                    // } else if (response.reqdets.tr_travel_mode == "Air") {
                    //     $("#travelmode_upd").find("option[value='Air']").prop('selected', true);
                    //     $("#travelmode_upd").find("option[value='Road']").prop('selected', false);
                    //     $("#travelmode_upd").find("option[value='Rail']").prop('selected', false);
                    // } else {
                    //     $("#travelmode_upd").find("option[value='Rail']").prop('selected', true);
                    //     $("#travelmode_upd").find("option[value='Road']").prop('selected', false);
                    //     $("#travelmode_upd").find("option[value='Air']").prop('selected', false);
                    // }

                    // //mileage
                    // if (response.reqdets.tr_mileage == "Alloted Vehicle") {
                    //     $("#mileage_upd").find("option[value='Alloted Vehicle']").prop('selected', true);
                    //     $("#mileage_upd").find("option[value='Own Conveyance']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', false);
                    // } else if (response.reqdets.tr_travel_mode == "Own Conveyance") {
                    //     $("#mileage_upd").find("option[value='Own Conveyance']").prop('selected', true);
                    //     $("#mileage_upd").find("option[value='Alloted Vehicle']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', false);
                    // } else if (response.reqdets.tr_travel_mode == "Own Conveyance") {
                    //     $("#mileage_upd").find("option[value='Own Conveyance']").prop('selected', true);
                    //     $("#mileage_upd").find("option[value='Alloted Vehicle']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', false);
                    // } else if (response.reqdets.tr_travel_mode == "Own Conveyance") {
                    //     $("#mileage_upd").find("option[value='Own Conveyance']").prop('selected', true);
                    //     $("#mileage_upd").find("option[value='Alloted Vehicle']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', false);
                    // } else {
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', true);
                    //     $("#mileage_upd").find("option[value='Alloted Vehicle']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Own Conveyance']").prop('selected', false);
                    // }
                    //mileage
                    if (response.reqdets.tr_travel_fare != null || response != '') {
                        var op1a = '<a target="_blank" href="myfiles/' + response.reqdets.tr_travel_fare + '">Click here to view</a>';
                        $("#trfare_upd_link").html(op1a);
                    } else {
                        var op1b = "<span>Not Uploaded</span>";
                        $("#trfare_upd_link").html(op1b);
                    }
                    if (response.reqdets.tr_tour_report != null || response != '') {
                        var op1b = '<a target="_blank" href="myfiles/' + response.reqdets.tr_tour_report + '">Click here to view</a>';
                        $("#tourrept_upd_link").html(op1b);
                    } else {
                        var op1b = "<span>Not Uploaded</span>";
                        $("#tourrept_upd_link").html(op1b);
                    }
                    if (response.reqdets.tr_lodg_fare != null || response != '') {
                        var op1c = '<a target="_blank" href="myfiles/' + response.reqdets.tr_lodg_fare + '">Click here to view</a>';
                        $("#lodgfare_upd_link").html(op1c);
                    } else {
                        var op1b = "<span>Not Uploaded</span>";
                        $("#lodgfare_upd_link").html(op1b);
                    }
                    if (response.reqdets.tr_other_exp != null || response != '') {
                        var op1d = '<a target="_blank" href="myfiles/' + response.reqdets.tr_other_exp + '">Click here to view</a>';
                        $("#other_exp_upd_link").html(op1d);
                    } else {
                        var op1b = "<span>Not Uploaded</span>";
                        $("#other_exp_upd_link").html(op1b);
                    }
                    $("#mileage_upd").val(response.reqdets.tr_mileage);
                    // if (response.reqdets.tr_mileage == "Alloted Vehicle") {
                    //     $("#mileage_upd").find("option[value='Alloted Vehicle']").prop('selected', true);
                    //     $("#mileage_upd").find("option[value='Own Conveyance']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', false);
                    // } else if (response.reqdets.tr_mileage == "Own Conveyance") {
                    //     $("#mileage_upd").find("option[value='Alloted Vehicle']").prop('selected', true);
                    //     $("#mileage_upd").find("option[value='Own Conveyance']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', false);
                    // } else if (response.reqdets.tr_mileage == "Public Transport") {
                    //     $("#mileage_upd").find("option[value='Alloted Vehicle']").prop('selected', true);
                    //     $("#mileage_upd").find("option[value='Own Conveyance']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', false);
                    // } else {
                    //     $("#mileage_upd").find("option[value='Alloted Vehicle']").prop('selected', true);
                    //     $("#mileage_upd").find("option[value='Own Conveyance']").prop('selected', false);
                    //     $("#mileage_upd").find("option[value='Public Transport']").prop('selected', false);
                    // }

                    $("#dist_upd").val(response.reqdets.tr_distance);
                    $('#modal-tour_report_edit').modal('toggle');
                }
            }
        });
    });

    $("#edit_attch_form").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "UpdMyTourReportDets",
            dataType: "JSON",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                alert(response.success);
                location.reload();
            },
            error: function(response) {
                alert("ERROR");
            }
        });
    });

    $("#tr_att1").click(function(e) {
        e.preventDefault();
        var tr_id = $("#tid").val();
        $.ajax({
            type: "post",
            url: "GetAttchs2",
            data: { tr_id: tr_id, did: 1 },
            success: function(response) {
                console.log(response);
                var req1 = "";
                for (var index = 0; index < response.reqs.length; index++) {
                    if (response.reqs[index].doc_id == 1) {
                        req1 += "<div class ='col-sm-4'>";
                        req1 += '<a target="_blank" href="myfiles/' + response.reqs[index].doc_name + '">Click here to view</a>';
                        req1 += "</div>";
                    }
                }
                $("#tr_att1_amt").html(response.amts[0].tr_travel_amt);
                $("#tr_att1_amt").show()
                $("#tr_att1").hide();
                $("#tr_att1_dwn").html(req1);
                $("#tr_att1_dwn").show();
            }
        });
    });

    $("#tr_att2").click(function(e) {
        e.preventDefault();
        var tr_id = $("#tid").val();
        $.ajax({
            type: "post",
            url: "GetAttchs2",
            data: { tr_id: tr_id, did: 2 },
            success: function(response) {
                console.log(response);
                var req2 = "";
                for (var index = 0; index < response.reqs.length; index++) {
                    if (response.reqs[index].doc_id == 2) {
                        req2 += "<div class ='col-sm-4'>";
                        req2 += '<a target="_blank" href="myfiles/' + response.reqs[index].doc_name + '">Click here to view</a>';
                        req2 += "</div>";
                    }
                }
                $("#tr_att2_amt").html(response.amts[0].tr_lodg_amt);
                $("#tr_att2_amt").show()
                $("#tr_att2").hide();
                $("#tr_att2_dwn").html(req2);
                $("#tr_att2_dwn").show();
            }
        });
    });

    $("#tr_att3").click(function(e) {
        e.preventDefault();
        var tr_id = $("#tid").val();
        $.ajax({
            type: "post",
            url: "GetAttchs2",
            data: { tr_id: tr_id, did: 3 },
            success: function(response) {
                console.log(response);
                var req3 = "";
                for (var index = 0; index < response.reqs.length; index++) {
                    if (response.reqs[index].doc_id == 3) {
                        req3 += "<div class ='col-sm-4'>";
                        req3 += '<a target="_blank" href="myfiles/' + response.reqs[index].doc_name + '">Click here to view</a>';
                        req3 += "</div>";
                    }
                }
                $("#tr_att3").hide();
                $("#tr_att3_dwn").html(req3);
                $("#tr_att3_dwn").show();
            }
        });
    });

    $("#tr_att4").click(function(e) {
        e.preventDefault();
        var tr_id = $("#tid").val();
        $.ajax({
            type: "post",
            url: "GetAttchs2",
            data: { tr_id: tr_id, did: 4 },
            success: function(response) {
                console.log(response);
                var req4 = "";
                for (var index = 0; index < response.reqs.length; index++) {
                    if (response.reqs[index].doc_id == 4) {
                        req4 += "<div class ='col-sm-4'>";
                        req4 += '<a target="_blank" href="myfiles/' + response.reqs[index].doc_name + '">Click here to view</a>';
                        req4 += "</div>";
                    }
                }
                $("#tr_att4_amt").html(response.amts[0].tr_other_amt);
                $("#tr_att4_amt").show()
                $("#tr_att4").hide();
                $("#tr_att4_dwn").html(req4);
                $("#tr_att4_dwn").show();
            }
        });
    });



});