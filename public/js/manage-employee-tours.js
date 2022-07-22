$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
    $("#tr_att1").click(function(e) {
        e.preventDefault();
        var tr_id = $("#tid").val();
        $.ajax({
            type: "post",
            url: "GetAttchs",
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
            url: "GetAttchs",
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
            url: "GetAttchs",
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
                $("#tr_att3_amt").html(response.amts[0].tr_da_amt);
                $("#tr_att3_amt").show()
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
            url: "GetAttchs",
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

    $(".btntr_rept_stat").click(function(e) {
        e.preventDefault();
        var rep_id = $(this).data('id');
        $("#depid").val(rep_id);
        $.ajax({
            type: "post",
            url: "EditReportStat",
            data: { rep_id: rep_id },
            success: function(response) {
                var myoptn = '';
                myoptn = '<option value="">Select Status</option>';
                for (var i1 = 0; i1 < response.tadas.length; i1++) {
                    myoptn += '<option value="' + response.tadas[i1].id + '" ' + (response.tadas[i1].id == response.req_datas[0].tadastat_id ? ' selected ' : '') + '>' + response.tadas[i1].tada_stat + '</option>';
                }
                $("#seltadastat").html(myoptn);
            }
        });
    });
    $(".btntr_view_rept").click(function(e) {
        e.preventDefault();
        var rep_id = $(this).data('id');
        $.ajax({
            type: "post",
            url: "GetAdv",
            data: { rep_id: rep_id },
            success: function(response) { //
                var valx = response.resl[0].tr_adv_allw;
                $("#adv_expend").val(valx);
                var valy = response.resl[0].tr_da_amt;
                $("#da_exp").val(valy);
                var sm = parseInt(response.resl[0].tr_adv_allw) +
                    parseInt(response.resl[0].tr_travel_amt) +
                    parseInt(response.resl[0].tr_lodg_amt) +
                    parseInt(response.resl.tr_da_amt) +
                    parseInt(response.resl.tr_other_amt);
            }
        });
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
    });

    $("#edit_rept_stat").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "UpdateTaDaStat",
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

// $("#taamt").val(response.reqdetss[0].tr_travel_amt);
// $("#lamt").val(response.reqdetss[0].tr_lodg_amt);
// $("#daamt").val(response.reqdetss[0].tr_other_amt);
// $("#oeamt").val(response.reqdetss[0].tr_da_amt);