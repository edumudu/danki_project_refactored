<?php
    Site::verificaPermissaoPage(2);

    $tb = 'tb_site.categorias';
    $page = 'add-categoria';

?>

<section class="box-content b1">
    <h2><i class="fas fa-plus-square"></i> Cadastrar novo cliente</h2>

    <form method="POST" class="ajax reset" action="<?php echo INCLUDE_PATH_PANEL.'ajax/forms.php';?>">
        <div class="form-group">
            <label for="name">Nome: </label>
            <input type="text" id="name" name="name" required />
        </div><!--form-group-->

        <div class="form-group">
            <label for="name">Email: </label>
            <input type="email" id="email" name="email" required />
        </div><!--form-group-->

        <div class="form-group">
            <label for="tipe">Tipo: </label>
            <select id="tipe" name="tipe" required>
                <option value="fisico" selected>Fisico</option>
                <option value="juridico" >Juridico</option>
            </select>
        </div><!--form-group-->

        <div ref="cpf" class="form-group">
            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" />
        </div><!--form-group-->

        <div ref="cnpj" class="form-group" style="display:none;">
            <label for="cnpj">CNPJ</label>
            <input type="text" name="cnpj" id="cnpj" />
        </div><!--form-group-->

        <div class="form-group file">
            <label for="img">Foto de perfil: </label>
            <label for="img" class="fake-file">Upload</label>
            <input id="img" type="file" accept="image/*" name="img" />
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" value="Adicionar" name="acao"/>
        </div><!--form-group-->
    </form>
</section>