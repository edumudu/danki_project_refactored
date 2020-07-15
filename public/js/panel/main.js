$(function(){

  let open = $('aside').is(':visible'),
      targetSize  = getSize();
  
  window.onresize = function(){
      targetSize = getSize();
      open = $('aside').is(':visible');
  }

  $('.menu-btn').click(function(){
      if(open){
          $('aside').animate({width: 0}, 1000);
          $('.panel-top').animate({'padding-left': 0}, 1000, function(){
              $('aside').css('display','none');
          });
      }else{
          $('.panel-top').animate({'padding-left': targetSize}, 1000);
          $('aside').css('display','block').animate({width: targetSize}, 1000);
      }
      open = !open;
  })

  function getSize(){
      return window.innerWidth <= 400 ? 200 : 300;
  }

  $('[format=date]').mask('99/99/9999',{
      placeholder: '__/__/____',
      clearIfNotMatch: true
  });

  $('.btn-delete').click(function(e){
    e.preventDefault();

    if(confirm("Você realmente deseja excluir este item?")){
      $.ajax({
        url: `${location.href}?excluir=${$(this).attr('id-ref')}`,
        method: 'delete',
        success () {
          location.reload()
        }
      })
    }
  })

  $('.order').click(function(e){
    e.preventDefault();

    const order = $(this).attr('order');
    const id = $(this).parent().attr('id');

    $.ajax({
      url: `${location.href}/order`,
      method: 'POST',
      data: {
        id,
        order
      },
      success () {
        location.reload();
      }
    })
  })
})