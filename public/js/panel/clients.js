$(function(){
    $('.box-action .btn-delete').click(function(e){
        e.preventDefault();
        let box = $(this).parent().parent().parent();
        $.ajax({
            url: 'http://localhost/Curso_Desenvolvimento_Web_Completo/Projetos/Projeto_01/panel/ajax/crud.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
                action: 'delete',
                data: {
                    tb: 'tb_admin.clientes',
                    id: box.attr('item_id'),
                    img: 'img'
                }
            }
        }).done(function(data){
            if(data.success){
                box.fadeOut(function(){
                    box.remove();
                });
            }
        })
    })
})