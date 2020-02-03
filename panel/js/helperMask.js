$(function(){
    $("[ref=cpf] input").mask('999.999.999-99');
    $("[ref=cnpj] input").mask('99.999.999/9999-99');

    $('[name=tipe]').change(function(){
        let val = $(this).val();
        if(val == 'fisico'){
            $('[ref=cpf]').show();
            $('[ref=cnpj]').hide();
        }else{
            $('[ref=cpf]').hide();
            $('[ref=cnpj]').show();
        }
    })
})