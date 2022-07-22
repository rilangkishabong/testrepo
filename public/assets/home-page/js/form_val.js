$(function() {
    $("#first_error_message").hide();
    $("#last_error_message").hide();
    $("#email_error_message").hide();
    $("#msg_error_message").hide();
    $("#captcha_error_message").hide();
    var error_username = false;
    var error_email = false;
    var error_msg = false;
    var captcha_msg = false;

    $("#form_first").focusout(function() {
        check_username();
    });
    $("#form_email").focusout(function() {
        check_email();
    });
    $("#msg_txt_message").focusout(function() {
        check_txtmsg();
    });
    $("#imgtxt_feedback").focusout(function() {
        check_captcha()
    });

    function check_username() {
        var username_length = $("#form_first").val().length;
        if (username_length < 5 || username_length > 20) {
            $("#first_error_message").html("Please Enter a Valid First Name.");
            $("#first_error_message").show();
            error_username = true;
        } else {
            $("#first_error_message").hide();
            error_username = false;
        }
    }

    function check_txtmsg() {
        var username_length = $("#msg_txt_message").val().length;
        if (username_length < 2) {
            $("#msg_error_message").html("Please Enter a Valid Message.");
            $("#msg_error_message").show();
            error_msg = true;
        } else {
            $("#msg_error_message").hide();
            error_msg = false;
        }
    }

    function check_email() {
        var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
        if (pattern.test($("#form_email").val())) {
            $("#email_error_message").hide();
            error_email = false;
        } else {
            $("#email_error_message").html("Invalid email address");
            $("#email_error_message").show();
            error_email = true;
        }
    }

    function check_captcha() {
        var imgtxt_feedback = $("#imgtxt_feedback").val().length;
        if (imgtxt_feedback < 5 || imgtxt_feedback > 20) {
            $("#captcha_error_message").html("Please Enter a Valid Captcha.");
            $("#captcha_error_message").show();
            captcha_msg = true;
        } else {
            $("#captcha_error_message").hide();
            captcha_msg = false;
        }
    }

    $("#registration_form").submit(function() {

        error_username = false;
        error_email = false;
        error_msg = false;
        captcha_msg = false;

        check_username();
        check_email();
        check_txtmsg();
        check_captcha();

        if (error_username == false && error_email == false && error_msg == false && captcha_msg == false) {
            if (confirm('Do you want to submit feedback.')) {
                var fname_txt = $("#form_first").val() + ' ' + $("#form_last").val();
                var email_txt = $("#form_email").val();
                var msg_txt = $("#msg_txt_message").val();
                var imgtxt_feedback = $("#imgtxt_feedback").val();
                var data1 = JSON.stringify({ name: fname_txt, email: email_txt, msg: msg_txt, imgtxt_feedback: imgtxt_feedback });
                $.ajax({
                    type: 'post',
                    url: 'feedback_us',
                    data: data1,
                    datatype: JSON,
                    contentType: 'application/json; charset=utf-8',
                    success: function(data) {
                        if (data.res_msg.cap_error) {
                            $("#captcha_error_message").show();
                            $("#captcha_error_message").html(data.res_msg.cap_error);
                        }
                        if (data.res_msg.cap_succ) {
                            $('.msg_div').addClass('alert alert-success');
                            $(".msg_div").text(data.res_msg.cap_succ);
                            $(".msg_div").delay(10000).fadeOut();
                            $("#registration_form input").val('');
                            $("#registration_form textarea").val('');
                        }
                        feedback_captcha_reset()
                    }
                })
                return false;
            } else {
                return false;
            }
        } else {
            return false;
        }
    });

});

$('#myModallogin').modal({
    backdrop: 'static',
    keyboard: false,
    show: false
});
addEventListener("load", function() {
    setTimeout(hideURLbar, 0);
}, false);

function hideURLbar() {
    window.scrollTo(0, 1);
}
document.getElementById("year").innerHTML = new Date().getFullYear();


$(document).ready(function() {
    $.ajax({
        type: 'post',
        url: 'RequestCounter',
        success: function(data) {
            console.log(data)
            $(".usercount").text(addCommas(data.val.usercount));
            $(".totalcount").text(addCommas(data.val.totalrequest));
            $(".pendingcount").text(addCommas(data.val.totalpending));
            $(".completedcount").text(addCommas(data.val.totalComplete));
        }
    });

    $("#refresh").on("click", function() {
        $('#captcha2').attr('src', 'Captcha?var=12345678' + Date.parse(new Date().toString()));
    });
});
$('.modal').on('shown.bs.modal', function() {
    $("#header").removeAttr("style");
    $("body").removeAttr("style");
    $(".modal").css({ paddingRight: "0px" });
    $("body").css({ 'overflow': "auto" });
});
$(".c-btn--action").click(function() {
    $("body").removeAttr("style");
})

var refreshes = parseInt(sessionStorage.getItem('refreshes'), 10) || 0;

sessionStorage.setItem('refreshes', ++refreshes);
$(window).load(function() {
    $('#myModal').modal({
        backdrop: 'static',
        show: true
    });
});

function loginEform() {
    bootbox.confirm({
        title: "Login Notice",
        message: `<ul class="login-ul">
            <li>For ease of user onboarding , eForms has now been integrated with NIC Single Sign-On Platform (Parichay). Now, users will be authenticated through Parichay(SSO).</li>
            <li>If you are a Non Gov user, Then Login from eForms Portal.</li>
        </ul>`,
        buttons: {
            confirm: {
                label: 'Login with EForms',
                className: 'btn-primary loginbtn'
            },
            cancel: {
                label: 'Login with Parichay (SSO)',
                className: 'btn-success loginbtn'
            }
        },
        callback: function(result) {
            if (result) {
                $('#myModallogin').modal({
                    backdrop: 'static',
                    keyboard: false
                })
            } else {

                window.location.href = 'https://parichay.nic.in/Accounts/NIC/index.html?service=eforms';

            }
        }
    });
}


$("#mod_close_mobile").click(function() {

    $("#myModallogin").modal('show');
})

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}