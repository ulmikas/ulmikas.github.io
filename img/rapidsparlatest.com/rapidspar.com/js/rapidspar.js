$(document).ready(function() {
    $("#contact_submit").click(function() {
        var proceed = true;
        $("#contact_form input[required=true], #contact_form textarea[required=true]").each(function() {
            $(this).css('border', 'none');
            if (!$.trim($(this).val())) { //if this field is empty
                $(this).css('border', '2px solid red'); //change border color to red
                proceed = false; //set do not proceed flag
            }
            //check invalid email
            var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if ($(this).attr("type") == "email" && !email_reg.test($.trim($(this).val()))) {
                $(this).css('border', '2px solid red'); //change border color to red
                proceed = false; //set do not proceed flag
            }
        });
        if (proceed) {
            post_data = {
                'name': $('input[name=name]').val(),
                'email': $('input[name=email]').val(),
                'phone': $('input[name=phone]').val(),
                'company': $('input[name=company]').val(),
                'message': $('textarea[name=message]').val()
            };
            //Ajax post data to server
            $.post('contact.php', post_data, function(response) {
                if (response.type == 'error') {
                  output = '<div class="error">' + response.text + '</div>';
                } else {
                  $('#contacts .contact-us__success').fadeIn();
                  setTimeout(function(){
                    $('#contacts .contact-us__success').fadeOut();
                  }, 3000);
                    // output = '<div class="success">' + response.text + '</div>';
                    // //reset values in all input fields
                    // $("#contact_form  input[required=true], #contact_form textarea[required=true]").val('');
                    // $("#contact_form #contact_body").slideUp(); //hide form after success
                }
                $("#contact_form #contact_results").hide().html(output).slideDown();
            }, 'json');
        }
        return false;
    });
    //reset previously set border colors and hide all message on .keyup()
    $("#contact_form  input[required=true], #contact_form textarea[required=true]").keyup(function() {
        $(this).css('border-color', '');
        $("#contact_results").slideUp();
    });


    $( ".frame-1" ).on( "click", function() {
        $('.s1').hide();
        $(this).hide();
        $('.firsframe').attr('src','anim/rapidspar-p1/rapidspar-p1.html');
    });
    $( ".frame-2" ).on( "click", function() {
        $('.s2').hide();
        $(this).hide();
        $('.secondframe').attr('src','anim/rapidspar-p2/rapidspar-p2.html');
    });
    $( ".frame-3" ).on( "click", function() {
        $('.s3').hide();
        $(this).hide();
        $('.threeframe').attr('src','anim/rapidspar-p3/rapidspar-p3.html');
    });

    $("body").on("click", ".modal-backdrop, #myModal .close, #myModal .btn", function() {
        $("#myModal iframe").attr("src", $("#myModal iframe").attr("src"));
    });
});
