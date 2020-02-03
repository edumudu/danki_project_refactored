<?php
    $tb = 'tb_site.servicos';

    Site::verificaPermissaoPage(1);
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $sqlData = Painel::selectSingle($tb, ['id' => $id]);
    }else
        die(Painel::alert('error','Você precisa pasar o parametro id.'));
    
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Editar Serviço</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['acao'])){
                if(Painel::update($tb, $_POST, ['id' => $id])){
                    Painel::alert('success','Serviço atualizado com sucesso.');
                    $sqlData = Painel::selectSingle($tb, ['id' => $id]);
                }else
                    Painel::alert('error','Campos vazios não são permitidos.');
            }
        ?>

        <div class="form-group">
            <label for="name">Serviço: </label>
            <textarea id="name" name="servico" required ><?php echo $sqlData['servico'];?></textarea>
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Atualizar" />
        </div><!--form-group-->
    </form>
</section><!--box-content-->