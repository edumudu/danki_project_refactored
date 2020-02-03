<?php 
    $tb = 'tb_site.noticias';
    $page = 'add-notice';
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Adicionar Notia</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['acao'])){

                $name = $_POST['title'];
                $img = $_FILES['img'];

                if(!$name)
                    Painel::alert('error','O campo nome não pode estar vazio.');
                else if(!$img['name'])
                    Painel::alert('error','O campo capa não pode estar vazio.');
                else if(!Painel::validImg($img))
                    Painel::alert('error','Formato ou tamnho da imagem não são suportados.');
                else{
                    if(Painel::equalsExisist($tb, ['title' => $_POST['title'], 'categoria_ref' => $_POST['categoria_ref']]))
                        Painel::alert('error','Ja existe uma notica com esse nome.');
                    else{
                        $img = Painel::uploadFile($img);
                        if($img){
                            $data = array_merge($_POST, ['capa' => $img, 'slug' => Painel::generateSlug($_POST['title'])]);
                            if(Painel::insert($tb, $data , true))
                                Painel::redirect(INCLUDE_PATH_PANEL.$page.'?success');
                            else
                                Painel::deleteFile($img);
                        }
                    }
                }
            }

            if(isset($_GET['success']) && !isset($_POST['acao']))
                Painel::alert("success",'Noticia adicionado com sucesso!');
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
            <input type="hidden" name="date" value="<?php echo date("Y-m-d");?>"
        </div><!--form-group-->

        <div class="form-group">
            <label for="title">Nome: </label>
            <input id="title" type="text" name="title" value="<?php recoverPost('title');?>" required />
        </div><!--form-group-->

        <div class="form-group">
            <label for="conteudo">Noticia: </label>
            <textarea id="conteudo" name="conteudo" class="tinymce" ><?php recoverPost('conteudo');?></textarea>
        </div><!--form-group-->

        <div class="form-group file">
            <label for="img">Capa da noticia: </label>
            <label for="img" class="fake-file">Upload</label>
            <input id="img" type="file" accept="image/*" name="img" />
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Adicionar" />
        </div><!--form-group-->
    </form>
</section><!--box-content-->