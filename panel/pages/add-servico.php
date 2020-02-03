<?php
    Site::verificaPermissaoPage(1);
    
    $tb = 'tb_site.servicos';
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Adicionar Serviço</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['acao'])){
                if(Painel::insert($tb, $_POST, true))
                    Painel::alert('success','Serviço cadastrado com sucesso.');
                else
                    Painel::alert('error','Campos vazios não são permitidos.');
            }
        ?>

        <div class="form-group">
            <label for="name">Serviço: </label>
            <textarea id="name" name="servico"  required></textarea>
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Cadastrar" />
        </div><!--form-group-->
    </form>
</section><!--box-content-->