$(document).ready(function() {

    $( ".show_more" ).on( "click", function() {

        if ($(this).is('.active'))  {
            $(".full_content").slideUp();
            $(".ext_content").show();
            $(this).removeClass('active');
        }else{
            $(".full_content").slideDown();
            $(".full_content").show();
            $(".ext_content").hide();
            $(this).addClass('active');
        }
        console.log( 'click'  );
    });

    $( ".frame-1" ).on( "click", function() {
        $('.s1').hide();
        $(this).hide();
        $('.firsframe').attr('src','/anim/rapidspar-p1/rapidspar-p1.html');
    });
    $( ".frame-2" ).on( "click", function() {
        $('.s2').hide();
        $(this).hide();
        $('.secondframe').attr('src','/anim/rapidspar-p2/rapidspar-p2.html');
    });
    $( ".frame-3" ).on( "click", function() {
        $('.s3').hide();
        $(this).hide();
        $('.threeframe').attr('src','/anim/rapidspar-p3/rapidspar-p3.html');
    });

    $( ".showvideo-mb" ).on( "click", function() {
        $('.youtube-mb').attr('src','http://www.youtube.com/embed/4Iy9NQqC9Dg?autoplay=1&enablejsapi=1');
    });

    $( ".showvideo-pc" ).on( "click", function() {
        $('.youtube-pc').attr('src','http://www.youtube.com/embed/4Iy9NQqC9Dg?autoplay=1&enablejsapi=1');
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        $('.youtube-pc').attr('src','#');
        $('.youtube-mb').attr('src','#');
        document.getElementById('youtube-mb').contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
        document.getElementById('youtube-pc').contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');

    })

    $(window).on('resize', function() {
        if ($(window).width() < 1200 && $(window).width()>991) {
            $('.tablet').hide();
        } else {
            $('.tablet').show();
        }

    });



});
