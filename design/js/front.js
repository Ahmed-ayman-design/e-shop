$(function () {
    'use strict';
  

    $('.loginp  h1 span').click(function(){

        $(this).addClass('active').siblings().removeClass('active');
        $('.loginp form').hide();    
        $('.'+$(this).data('class')).fadeIn(100);
    });
    

    $('[placeholder]').focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    $('input').each(function () {
        if ($(this).attr('required') === 'required') {
            $(this).after('<span class="asterisk">*</span>');
        }

    });

    
    $(".confirm").click(function () {
        return confirm("are you sure?");
    })

// $(".live-name").keyup(function(){
//     $(".live-preview .caption h3").text($(this).val());
// })
// $(".live-des").keyup(function(){
//     $(".live-preview .caption p").text($(this).val());
// })
// $(".live-price").keyup(function(){
//     $(".live-preview span").text('$'+$(this).val());
// })

$(".live").keyup(function(){
    // $(".live-preview .caption h3").text($(this).val());
    // console.log($(this).data("class"));
    $($(this).data("class")).text($(this).val());
})
});


