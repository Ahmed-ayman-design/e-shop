$(function () {
    
    //  
    //toggle
    $(".toggle-info").click(function(){
    $(this).toggleClass("selected").parent().next(".panel-body").fadeToggle(100);
    if($(this).hasClass("selected")){
        $(this).html( '<i class="fa fa-minus fa-lg"></i>');
    }else{
        $(this).html( '<i class="fa fa-plus fa-lg"></i>');
    }
     });
    
    //hide placeholder on form focus
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

    var passfill = $('.password');
    $('.show - pass').hover(function () {
        passfill.attr('type', 'text');

    }, function () {
        passfill.attr('type', 'password');

    });
    $(".confirm").click(function () {
        return confirm("are you sure?");
    })
//category
$('.cat h3').click(function(){
    $(this).next('.full-view').fadeToggle(200);
});
$('.ordering span').click(function(){
    $(this).addClass('active').siblings('span').removeClass('active');
    if($(this).data('view')==='full'){
        $('.cat .full-view').fadeIn(200);
    }else{
        $('.cat .full-view').fadeOut(200);
    }
});




// show delete butto on childcat
$('.child-link').hover(function(){
    $(this).find('.show-delete').fadeIn(300);
    }, function(){
        $(this).find('.show-delete').fadeOut(300);
    });

    'use strict';
    $("select").selectBoxIt({
        autowidth:false
    });


});


