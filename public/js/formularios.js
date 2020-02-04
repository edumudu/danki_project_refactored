$(function(){
    $('body').on('submit', 'form.ajax-form', function(e){
        e.preventDefault();

        let form = $(this),
            loader = $('#ajax-loader');
        $.ajax({
            url: `ajax/formularios.php`,
            method: 'POST',
            datatype: 'JSON',
            data: form.serialize(),
            beforeSend: function(){
                loader.css('display','flex');
            }
        }).done(function(data){
            loader.fadeOut();

            if(data.success){
                form.trigger('reset');
                $('.success').fadeIn();
                setTimeout(function(){
                    $('.success').fadeOut();
                }, 3000)
            }else{
                $('.fail').fadeIn();
                setTimeout(function(){
                    $('.fail').fadeOut();
                }, 3000)
            }
        })
    })
})