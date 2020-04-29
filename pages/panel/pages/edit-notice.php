<?php
    $tb = 'tb_site.noticias';

    Site::verificaPermissaoPage(1);
    if(isset($_GET['id']))
        $sqlData = Painel::selectSingle($tb, ['id' => $_GET['id']]);
    else
        die(Painel::alert('error','Você precisa pasar o parametro id.'));
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Editar usuario</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['acao'])){

                $queryOk = true;
                $name = $_POST['title'];
                $img = $_FILES['img']['name'] !== '' ? $_FILES['img'] : $_POST['img_atual'];

                if(is_array($img)){
                    if(Painel::validImg($img)){
                        $img = Painel::uploadFile($img);
                        if(!$img) $queryOk = false;
                        else Painel::deleteFile($_POST['img_atual']);
                    }else{
                        $queryOk = false;
                        Painel::alert('error','O formato da imagem não é valido.');
                    }
                        
                }
                
                if($queryOk){
                    if(Painel::equalsExisist($tb, ['title' => $name, 'categoria_ref' => $_POST['categoria_ref']], $_GET['id']))
                        Painel::alert('error','Ja existe uma noticia om esse nome');
                    else{
                        $data = [
                            "categoria_ref" => $_POST['categoria_ref'],
                            "date" => date('Y-m-d'),
                            "title" => $_POST['title'], 
                            "conteudo" => $_POST['conteudo'], 
                            "capa" => $img, 
                            "slug" => Painel::generateSlug($name)];
                        if(Painel::update($tb, $data, ['id' => $sqlData['id']])){
                            Painel::alert('success','Atualizado com sucesso!');
                            $sqlData = Painel::selectSingle($tb, ['id' => $_GET['id']]);
                        }else
                            Painel::alert('error','Ocorreu um erro ao atualizar.'); 
                    }
                }
            }
        ?>

        <div class="form-group">
            <label for="categoria">Categoria: </label>
            <select id="categoria" name="categoria_ref">
                <?php 
                    $categorias = Painel::selectAll('tb_site.categorias');
                    foreach($categorias as $value){
                ?>
                    <option <?php if($value['id'] == @$_POST['categoria_ref']) echo 'selected';?> value="<?php echo $value['id'];?>"><?php echo $value['name']?></option>
                <?php }?>
            </select>
        </div><!--form-group-->


        <div class="form,-group">
            <label for="name">Name: </label>
            <input id="name" type="text" name="title" value="<?php echo $sqlData['title'];?>" required />
        </div><!--form-group-->

        <div class="form,-group">
            <label for="name">Conteudo: </label>
            <textarea id="name" type="text" name="conteudo" class="tinymce"><?php echo $sqlData['conteudo'];?></textarea>
        </div><!--form-group-->

        <div class="form-group file">
            <label for="img">Slide: </label>
            <label for="img" class="fake-file">Upload</label>
            <input id="img" type="file" accept="image/*" name="img" />
            <input type="hidden" name="img_atual" value="<?php echo $sqlData['capa'];?>" />
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Atualizar" required />
        </div><!--form-group-->
    </form>
</section><!--box-content-->