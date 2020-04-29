<?php
    Site::verificaPermissaoPage(2);
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Adicionar usuario</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['add'])){
                
                $login = $_POST['login'];
                $nome = $_POST['nome'];
                $pass = $_POST['senha'];
                $cargo = $_POST['cargo'];
                $img = $_FILES['img'];

                if(!$login)
                    Painel::alert('error','O login não pode estar vazio.');
                else if(!$nome)
                    Painel::alert('error','O nome não pode estar vazio.');
                else if(!$pass)
                    Painel::alert('error','A senha não pode estar vazio.');
                else if($cargo == '' || $cargo > $_SESSION['cargo'])
                    Painel::alert('error','Você precisa selecionar um cargo menor que o seu.');
                else if(!Painel::validImg($img))
                    Painel::alert('error','Você precisa selecionar uma imagem valida.');
                else if(Usuario::userExists($login))
                    Painel::alert('error',"O usuario $login ja existe");
                else{
                    $user = new Usuario;
                    $imagem = Painel::uploadFile($img);
                    $user->addUser($login, $pass, $imagem, $nome, $cargo);
                    Painel::alert('success',"O cadastro do usuario $login foi feito com sucesso");
                }
            
            }
        ?>

        <div class="form-group">
            <label for="login">Login: </label>
            <input id="login" type="text" name="login"  />
        </div><!--form-group-->

        <div class="form-group">
            <label for="name">Nome: </label>
            <input id="name" type="text" name="nome"  />
        </div><!--form-group-->

        <div class="form-group">
            <label for="pass">Senha: </label>
            <input id="pass" type="password" name="senha"  />
            
        </div><!--form-group-->

        <div class="form-group">
            <label for="cargo">Cargo: </label>
            <select name="cargo" id="cargo">
                <?php foreach(Painel::$cargos as $key => $value) {
                    if($key < $_SESSION['cargo']) {   
                ?>
                    <option value="<?php echo $key; ?>"><?php echo $value?></option>
                <?php }}?>
            </select>
        </div>

        <div class="form-group file">
            <label for="img">Foto de perfil: </label>
            <label for="img" class="fake-file">Upload</label>
            <input id="img" type="file" accept="image/*" name="img" />
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="add" value="Adicionar" />
        </div><!--form-group-->
    </form>
</section><!--box-content-->