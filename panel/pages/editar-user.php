<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Editar usuario</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['acao'])){

                $queryOk = true;
                $name = $_POST['name'];
                $pass = $_POST['pass'];
                $img = $_FILES['img']['name'] ? $_FILES['img'] : $_POST['img_atual'];

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
                    $user = new Usuario;
                    if($user->updateUser($name, $pass, $img)){
                        Painel::alert('success','Atualizado com sucesso!');
                        $_SESSION['img'] = $img;
                    }
                    else
                        Painel::alert('error','Ocorreu um erro ao atualizar.'); 
                }
                
            }
        ?>


        <div class="form,-group">
            <label for="name">Nome: </label>
            <input id="name" type="text" name="name" value="<?php echo $_SESSION['name'];?>" required />
        </div><!--form-group-->

        <div class="form-group">
            <label for="pass">Senha: </label>
            <input id="pass" type="password" name="pass" value="<?php echo $_SESSION['password'];?>" required />
            
        </div><!--form-group-->

        <div class="form-group file">
            <label for="img">Foto de perfil: </label>
            <label for="img" class="fake-file">Upload</label>
            <input id="img" type="file" accept="image/*" name="img" />
            <input type="hidden" name="img_atual" value="<?php echo $_SESSION['img'];?>" />
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Atualizar" required />
        </div><!--form-group-->
    </form>
</section><!--box-content-->