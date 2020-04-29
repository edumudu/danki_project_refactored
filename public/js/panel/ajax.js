$(function(){
    $('form.ajax').ajaxForm({
        dataType: "JSON",
        beforeSend: function(){
            $('form.ajax').animate({opacity: 0.7})
            $('form.ajax [type=submit]').attr('disabled', true);
        },
        success: function(data){
            if(data.success){
                $('body').prepend(`<div class="success float">
                   ${data.message}!
                </div>`)

                setTimeout(function(){
                    $('div.success').remove();
                },5000)

                if($('form.ajax').hasClass('reset'))
                    $('form.ajax')[0].reset();
            }else{
                $('body').prepend(`<div class="error float">
                    ${data.message}<br />
                </div>`)

                setTimeout(function(){
                    $('div.error').remove();
                },5000)
            }
        },
        complete: function(){
            $('form.ajax').animate({opacity: 1})
            $('form.ajax [type=submit]').attr('disabled', false);
        }
    })
})