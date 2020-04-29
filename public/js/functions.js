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
})