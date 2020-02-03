$(function(){
    $('nav.mobile i').click(function(){
        let el = $('nav.mobile ul'),
            icon = $(this);
        
        if(el.is(':hidden'))
            icon.removeClass('fa-bars').addClass('fa-times');
        else
            icon.removeClass('fa-times').addClass('fa-bars');

        el.slideToggle();
    })
    
    function scroll(){
        let target = $('target').attr('target');
        if(target !== undefined){
            let offset = $(`#${target}`).offset();
            $('html, body').animate({scrollTop: offset.top})
        }
    }

    if($('target') !== undefined)
        scroll();
})