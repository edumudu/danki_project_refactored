<?php
    Site::verificaPermissaoPage(1);

    $tb = 'tb_site.depoimentos';
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $depoimento = Painel::selectSingle($tb, ['id' => $id]);
    }else
        die(Painel::alert('error','Você precisa pasar o parametro id.'));
    
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Editar Depoimento</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['acao'])){
                $_POST['date'] = date('Y-m-d');
                if(Painel::update($tb, $_POST, ['id' => $id])){
                    Painel::alert('success','Depoimento atualizado com sucesso.');
                    $depoimento = Painel::selectSingle('tb_site.depoimentos', ['id' => $id]);
                }else
                    Painel::alert('error','Campos vazios não são permitidos.');
            }
        ?>

        <div class="form-group">
            <label for="name">Nome da pessoa: </label>
            <input id="name" type="text" name="name"  value="<?php echo $depoimento['name'];?>" required />
        </div><!--form-group-->

        <div class="form-group">
            <label for="depoimento">Depoimento: </label>
            <textarea id="depoimento" name="depoimento" required ><?php echo $depoimento['depoimento'];?></textarea>
        </div><!--form-group-->

        <!--<div class="form-group">
            <label for="date">Data: </label>
            <input type="text" id="date" name="date" format="date" value="<?php echo date('d/m/Y', strtotime($depoimento['date']));?>" required />
        </div>--><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Atualizar" />
        </div><!--form-group-->
    </form>
</section><!--box-content-->