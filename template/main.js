

jQuery(document).ready(function () {
    
    jQuery('.agree_input').click(function (e) {
        jQuery(this).toggleClass('active')
    });
   
   
    jQuery('.span_circle').on('click',function(){
        var
            parent = jQuery(this).parent('.step_link'),
            data = parent.data('step');

        jQuery('.steps_name_box').find('.st_name').removeClass('active');
        jQuery('.steps_name_box').find('.'+data).addClass('active');

        parent.addClass('active').prevAll().addClass('active');
        parent.nextAll().removeClass('active');

        jQuery('.main_tap_wrap').children('.'+data).prevAll().removeClass('active');
        jQuery('.main_tap_wrap').children('.'+data).nextAll().removeClass('active');
        jQuery('.main_tap_wrap').children('.'+data).addClass('active')
    })

    
});