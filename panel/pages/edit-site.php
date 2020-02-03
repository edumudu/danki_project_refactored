<?php
    $tb = 'tb_site.config';
    $sqlData = Painel::selectSingle($tb,['id' => 1]);
    $id = 1;
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Editar Configurações site</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['acao'])){
                if(Painel::update($tb, $_POST, ['id' => $id])){
                    Painel::alert('success','Site atualizado com sucesso.');
                    $sqlData = Painel::selectSingle($tb,['id' => $id]);
                }else
                    Painel::alert('error','Campos vazios não são permitidos.');
            }
        ?>

        <div class="form-group">
            <label for="name">Titulo: </label>
            <input type="text" id="name" name="titulo" value="<?php echo $sqlData['titulo']?>" required >
        </div><!--form-group-->

        <div class="form-group">
            <label for="name">Nome do autor: </label>
            <input type="text" id="name" name="name_author" value="<?php echo $sqlData['name_author']?>" required >
        </div><!--form-group-->

        <div class="form-group">
            <label for="name">Serviço: </label>
            <textarea id="name" name="descricao" required ><?php echo $sqlData['descricao']?></textarea>
        </div><!--form-group-->

        <?php for($i = 1; $i <= 3; $i++){?>
        
        <div class="form-group">
            <label for="name">Icone <?php echo $i;?> </label>
            <input type="text" id="name" name="icone_<?php echo $i;?>" value="<?php echo $sqlData["icone_$i"]?>" required >
        </div><!--form-group-->

        <div class="form-group">
            <label for="name">Descricao do incone <?php echo $i;?>: </label>
            <textarea id="name" name="descricao_<?php echo $i;?>" required ><?php echo $sqlData["descricao_$i"]?></textarea>
        </div><!--form-group-->

        <?php }?>

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Atualizar" />
        </div><!--form-group-->
    </form>
</section><!--box-content-->