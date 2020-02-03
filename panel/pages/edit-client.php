<?php
    $tb = 'tb_admin.clientes';

    Site::verificaPermissaoPage(1);
    if(isset($_GET['id']))
        $sqlData = Painel::selectSingle($tb, ['id' => $_GET['id']]);
    else
        die(Painel::alert('error','Você precisa pasar o parametro id.'));
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Editar Cliente</h2>

    <form method="POST" enctype="multipart/form-data" class="ajax" action="<?php echo INCLUDE_PATH_PANEL.'ajax/crud.php'; ?>">
        <input type="hidden" name="tb" value="tb_admin.clientes" />
        <input type="hidden" name="id" value="<?php echo $sqlData['id']; ?>" />
        <input type="hidden" name="action" value="update" />

        <div class="form-group">
            <label for="name">Name: </label>
            <input id="name" type="text" name="name" value="<?php echo $sqlData['name'];?>" required />
        </div><!--form-group-->

        <div class="form-group">
            <label for="email">email: </label>
            <input id="email" type="text" name="email" value="<?php echo $sqlData['email'];?>" required />
        </div><!--form-group-->

        <div class="form-group">
            <label for="tipe">Tipo: </label>
            <select name="tipe">
                <option value="fisico" <?php echo $sqlData['tipe'] === "fisico" ? "selected" : ""; ?>>Fisico</option>
                <option value="juridico" <?php echo $sqlData['tipe'] === "juridico" ? "selected" : ""; ?>>Juridico</option>
            </select>
        </div><!--form-group-->

        <div ref="cpf" class="form-group" <?php echo $sqlData['tipe'] === "juridico" ? 'style="display:none;"' : "" ?>>
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" value="<?php echo $sqlData['cpf_cnpj']; ?>" />
        </div><!--form-group-->

        <div ref="cnpj" class="form-group" <?php echo $sqlData['tipe'] === "fisico" ? 'style="display:none;"' : "" ?>>
            <label for="cnpj">CNPJ</label>
            <input type="text" name="cnpj" id="cnpj" value="<?php echo $sqlData['cpf_cnpj']; ?>" />
        </div><!--form-group-->

        <div class="form-group file">
            <label for="img">imagem: </label>
            <label for="img" class="fake-file">Upload</label>
            <input id="img" type="file" accept="image/*" name="img" />
            <input type="hidden" name="img_atual" value="<?php echo $sqlData['img'];?>" />
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Atualizar" />
        </div><!--form-group-->
    </form>
</section><!--box-content-->