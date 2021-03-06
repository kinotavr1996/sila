jQuery(document).ready(function () {
    
    jQuery('.agree_input').click(function (e) {
        jQuery(this).toggleClass('active')
    });
   
    function navigator(selector){
        var
            parent = jQuery(selector).parent('.step_link'),
            data = parent.data('step');

        jQuery('.steps_name_box').find('.st_name').removeClass('active');
        jQuery('.steps_name_box').find('.'+data).addClass('active');

        parent.addClass('active').prevAll().addClass('active');
        parent.addClass('active').prevAll().removeClass('current');

        parent.addClass('current');

        parent.nextAll().removeClass('active');

        jQuery('.main_tap_wrap').children('.'+data).prevAll().removeClass('active');
        jQuery('.main_tap_wrap').children('.'+data).nextAll().removeClass('active');
        jQuery('.main_tap_wrap').children('.'+data).addClass('active');
        var step = parseInt($('.step_link.current').attr('id').split('_')[1]);

        if(step > 3)
            $('.project_btn.project').show();
        else
            $('.project_btn.project').hide();

        if(step > 1)
            $('.project_btn.back').show();
        else
            $('.project_btn.back').hide();

        if(step < 4)
            $('.project_btn.next').show();
        else
            $('.project_btn.next').hide();   

        $('.project_btn.plan').click(function(){
            window.href = '/';
        });
    }

    jQuery(".active_lang").click(function () {
        if( jQuery(".lang_box").css('display')=="none"){
            jQuery(this).toggleClass("open");
            jQuery('.lang_box').slideDown()
        }else{
            jQuery(this).toggleClass("open");
            jQuery('.lang_box').slideUp();
        }
     });
    $('.active_lang').text($('.lang-active').text());


    $('.about_tabs_self li').click(function(){
        var t = $(this).attr('id');
      
        if(!$(this).hasClass('active')){ //this is the start of our condition 
          $('.about_tabs_self li').removeClass('active');           
          $(this).addClass('active');
      
          $('.about_content').hide();
          $('#'+ t + 'C').fadeIn('slow');
       }
      });
      $('#created_by').val('Guest');
      $('.order_call_box').click(function(e){
        e.preventDefault();
        $('.button-joomly-callback-form').click();
      });

      $('.project_btn.next, .decision .pass_btn').click(function(){
        var flag = parseInt($('.finally-decision').val());
            var currentStep = parseInt($('.step_link.active.current').attr("id").split('_')[1]);
            currentStep++;
        if(flag > 0 && currentStep - 1 == 3)
            navigator($($('#step_' + currentStep).find('.span_circle')).selector);
        if(currentStep - 1 != 3)
            navigator($($('#step_' + currentStep).find('.span_circle')).selector);
      });

      $('.project_btn.back').click(function(){
        var currentStep = parseInt($('.step_link.active.current').attr("id").split('_')[1]);
        currentStep--;
        navigator($($('#step_' + currentStep).find('.span_circle')).selector);
      });

      $('.project').click(function(){
        navigator($($('#step_2').find('.span_circle')));
      });

      $(".pass_btn").click(function(){
          var projectCost = parseInt($('.project-cost').val()),
            percent = parseInt($('.project-percent').val()),
            projectProfit = parseInt($('.profit').val()),
            yourDecision = parseInt($('.yourDecision').val()),
            yourProfit = 0;

            yourProfit = projectProfit /(projectCost / yourDecision);
            $('.yourProfit').val(yourProfit);
            $('.finally-decision').val(yourProfit);
      });
    
      $(".passport_cal_wrap .pass_btn").click(function(){
        var percent = parseInt($('.percent').val()),
          yourDecision = parseInt($('.decision').val()),
          yourProfit = 0;
          yourProfit = yourDecision * percent / 100;
          $('.profit').val(yourProfit);
          $('.finally-decision').val(yourDecision);
          $('.finally-decision').text(yourDecision);
    });

    $('.rate_self').click(function(){
        $('.rate_self').removeClass('active');
        $(this).toggleClass('active');
    });
});