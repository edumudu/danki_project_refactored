<?php 
    $tb = 'tb_site.slides';
    $page = 'add-slides';
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Adicionar Slide</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['acao'])){

                $name = $_POST['name'];
                $img = $_FILES['img'];

                if(!$name)
                    Painel::alert('error','O campo nome não pode estar vazio.');
                else if(!$img['name'])
                    Painel::alert('error','O campo Slide não pode estar vazio.');
                else if(!Painel::validImg($img, 1500))
                    Painel::alert('error','Formato ou tamnho da imagem não são suportados.');
                else{
                    $img = Painel::uploadFile($img);
                    if($img){
                        $data = [
                            'name' => $name,
                            'slide' => $img
                        ];
                        if(Painel::insert($tb, $data, true))
                            Painel::alert("success",'Slide adicionado com sucesso!');
                        else
                            Painel::deleteFile($img);
                    }
                }
                
            
            }
        ?>

        <div class="form-group">
            <label for="name">Nome: </label>
            <input id="name" type="text" name="name"  />
        </div><!--form-group-->

        <div class="form-group file">
            <label for="img">Slide: </label>
            <label for="img" class="fake-file">Upload</label>
            <input id="img" type="file" accept="image/*" name="img" />
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Adicionar" />
        </div><!--form-group-->
    </form>
</section><!--box-content-->