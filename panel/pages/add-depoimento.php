<?php
    Site::verificaPermissaoPage(1);
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Adicionar Depoimento</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['acao'])){
                $_POST['date'] = date('Y-m-d');
                if(Painel::insert('tb_site.depoimentos', $_POST, true))
                    Painel::alert('success','Depoimento cadastrado com sucesso.');
                else
                    Painel::alert('error','Erro ao cadastrar depoimento.');
            }
        ?>

        <div class="form-group">
            <label for="name">Nome da pessoa: </label>
            <input id="name" type="text" name="name"  required />
        </div><!--form-group-->

        <div class="form-group">
            <label for="depoimento">Depoimento: </label>
            <textarea id="depoimento" name="depoimento" required ></textarea>
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Cadastrar" />
        </div><!--form-group-->
    </form>
</section><!--box-content-->