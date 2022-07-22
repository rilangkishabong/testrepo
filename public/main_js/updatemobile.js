$('#update-mobile').submit(function (e) {

    //$('.loader').show();
    e.preventDefault();
    var email = $('#update-mobile #email').val();
    var password = $('#update-mobile #password').val();
    var newmobile = $('#update-mobile #newmobile').val();
    var newcode = $('#update-mobile #newMobilecode').val();


    var emailregn = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ((email !== null && email !== "")) {
        if (email.match(emailregn)) {
            if ((password === null || password === "")) {
                $('#continue').attr("disabled", true);
                var dataObj = {userValues: {email: email}};
                var data1 = JSON.stringify(dataObj);

                $.ajax({
                    type: "POST",
                    url: "AuthEmail",
                    data: data1,
                    datatype: JSON,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {
                        $('.loader').hide();
                        console.log(data);
                        if (!data.errors) {
                            $('#update-mobile #continue').attr("disabled", false);
                            //alert(data.userValues.isEmailValidated)
                            if (data.userValues.isEmailValidated) {

                                if ((email == "support@nic.in" || email == "support@gov.in" || email == "support@nkn.in" || email == "smssupport@nic.in" || email == "vpnsupport@nic.in") && (mobile == null || mobile == "")) {
                                    $('#captcha_div').addClass("display-hide");
                                }

                                $('#update-mobile #email').prop('readonly', true);
                                $('#update-mobile #password-div').removeClass('display-hide');
                                $('#update-mobile #password').focus();
                                $("#update-mobile input[name='isNewUser']").val(data.userValues.isNewUser);
                                $("#update-mobile input[name='isEmailValidated']").val(data.userValues.isEmailValidated);
                            } else {

                                $('#update-mobile #email_error').html("Please come with government email address.");
                            }
                        } else {
                            if (data.errors.email === 'empty')
                                $('#update-mobile #email_error').html("Please Enter Your Email Address");
                            else
                                $('#update-mobile #email_error').html("Please Enter Your Email in correct format.");
                            return false;
                        }
                    }
                });
            } else if ((password !== null && password !== "") && (newmobile == null || newmobile == "")) {

                var isNewUser = $("input[name='isNewUser']").val();
                var dataObj = {userValues: {email: email, password: password, isNewUser: isNewUser}};
                var data1 = JSON.stringify(dataObj);
                $.ajax({
                    type: "POST",
                    url: "AuthPwdForUpdateMobile",
                    data: data1,
                    datatype: JSON,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data) {

                        $('.loader').hide();
                        if (!data.errors) {
                            if (data.userValues.isEmailValidated) {
                                $("#mobile-otp-div small.update-notify").html('If you want to update your mobile number in NIC central repositary, please click on (<a href="#" onclick="updatemob()" class="updatemob">Update Mobile</a>)')
                            }
                            if (data.userValues.loginCaptchaAuthenticated === true) {
                                if (data.userValues.authenticated === true) {

                                    $('#update-mobile #continue').attr("disabled", true);
                                    $("input[name='new_mobile']").val(data.userValues.mobile);
                                    $("input[name='country_code_val']").val(data.userValues.countryCode);
                                    $("input[name='isNewUser']").val(data.userValues.isNewUser);
                                    $("input[name='isEmailValidated']").val(data.userValues.isEmailValidated);
                                    $("input[name='isIsNicEmployee']").val(data.userValues.isNICEmployee);
                                    $('#update-mobile #email_error').html("");
                                    $('#update-mobile #new-mobile').removeClass("display-hide");
                                    $('#update-mobile #signup-tab').addClass("display-hide");
                                    $('#update-mobile #password_error').text("");



                                } else {
                                    // show password field
                                    $('#update-mobile #mobile-div').addClass("display-hide");
                                    $('#update-mobile #password-div').removeClass("display-hide");
                                    $('#update-mobile #password_error').text("Please enter correct password");
                                    $('#update-mobile #password').focus();
                                    
                                }
                            } else {
                                $('#captcha2').attr('src', 'Captcha?var=12345678' + Date.parse(new Date().toString()));
                                danger_msg("Please enter correct captcha code.")
                                $('#logincaptchaerror').focus();
                                return false;
                            }
                        } else {
                            if (data.errors.email === 'empty')
                                $('#update-mobile #email_error').html("Please Enter Your Email Address");
                            else
                                $('#update-mobile #email_error').html("Please Enter Your Email in correct format.");
                            return false;
                        }
                    },
                    error: function () {
                        $('.loader').hide();
                        console.log('error');
                        return false;
                    }
                });
                $('#update-mobile #email_error').html("");

                $('#update-mobile #logincaptchaerror').html("");
            } else if ((password !== null && password !== "") && (newmobile !== null && newmobile !== "") && (newcode == null || newcode == "")) {
                var isNewUser = $("input[name='isNewUser']").val();
                var dataObj = {userValues: {new_mobile: newmobile, email: email, password: password, isNewUser: isNewUser}};
                var data1 = JSON.stringify(dataObj);
                $.ajax({
                    type: "POST",
                    url: "Otpgen_newmobile",
                    data: data1,
                    datatype: JSON,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data)
                    {

                        $('.loader').hide();
                        console.log("dataaaaaaaaaaaa" + data.returnString)
                        console.log("return output 2222222222if click new mobile" + data.userValues.returnString)
                        if (data.userValues.authenticated === true) {
                            if (data.userValues.returnString == "moberr")
                            {
                                $("#update-mobile #new-code").addClass("display-hide");
                                $("#update-mobile #succ_msg").hide();
                                $('#update-mobile #moberr').html("Please Enter Mobile in correct format with country code e.g +91XXXXXXXXXX");
                            } else if (data.userValues.returnString == "mobileInLdap")
                            {
                                $("#update-mobile #new-code").addClass("display-hide");
                                $("#update-mobile #succ_msg").hide();
                                $('#update-mobile #moberr').html("There is already an email address associated with this mobile number so the same mobile number can't be updated");
                            } else if (data.userValues.returnString == "same")
                            {
                                $('#update-mobile #moberr').html("This is the same number you are updating");
                                $("#update-mobile #new-code").addClass("display-hide");
                                $("#update-mobile #succ_msg").hide();
                                $('#update-mobile #succ_err').html("");
                                $("#update-mobile #newcode").val('');
                            } else {
                                $("#update-mobile #new-code").removeClass("display-hide");
                                $("#update-mobile #succ_msg").show();
                                $("#update-mobile #succ_msg").html("OTP Sent to entered Mobile Number.")
                                $('#update-mobile #moberr').html("");

                            }
                        }
                    }, error: function ()
                    {
                        $('.loader').hide();
                        console.log("error in old code verify")
                    }
                })

            } else if ((password !== null && password !== "") && (newmobile !== null && newmobile !== "") && (newcode !== null && newcode !== "")) {


                var mobile = $("input[name='new_mobile']").val();
                var isNewUser = $("input[name='isNewUser']").val();
                var dataObj = {userValues: {new_mobile: newmobile, newcode: newcode, isNewUser: isNewUser, email: email, mobile: mobile, password: password}};
                var data1 = JSON.stringify(dataObj)
                $.ajax({
                    type: "POST",
                    url: "verify_newmobile_code",
                    data: data1,
                    datatype: JSON,
                    contentType: 'application/json; charset=utf-8',
                    success: function (data)
                    {
                        $('.loader').hide();
                        if (data.userValues.authenticated === true) {
                            if (data.userValues.returnString == "new_code_err")
                            {
                                $('#update-mobile #file_cert_err').html("Please enter new otp code in correct format");
                            } else if (data.userValues.returnString == "newOtpNotMatch")
                            {
                                $('#update-mobile #file_cert_err').html("Please enter correct new otp");
                            } else if (data.userValues.returnString == "newuser")
                            {
                                window.location.href = "profile";
                            } else if (data.userValues.returnString == "olduser")
                            {
                                window.location.href = "Mobile_registration";
                            } else if (data.userValues.returnString == "mobilesamehod")
                            {
                                $('#update-mobile #moberr').html("You can not update your mobile number same as of your reporting officer");
                                $("#update-mobile #newcode").val('');
                            } else if (data.userValues.returnString == "mobilesameus")
                            {
                                $('#update-mobile #moberr').html("You can not update your mobile number same as of your Under Secratery");
                                $("#update-mobile #newcode").val('');
                            }
                        }
                    }, error: function ()
                    {
                        $('.loader').hide();
                        console.log("error in new code ")
                    }
                })
            }

        } else {
            $('.loader').hide();
            $('#update-mobile #email_error').html("Please Enter Your Email Address in correct format");
        }
    } else {
        $('.loader').hide();
        $('#update-mobile #email_error').html("Please Enter Your Email Address");
    }
});