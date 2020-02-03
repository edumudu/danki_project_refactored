<?php
    $tb = 'tb_site.categorias';

    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $sqlData = Painel::selectSingle($tb,['id' => $id]);
    }else
        die(Painel::alert("error", 'Você precisa informar um id.'));
?>

<section class="box-content b1">
    <h2><i class="fas fa-user-edit"></i> Editar Categoria</h2>

    <form method="POST" enctype="multipart/form-data">
        <?php
            if(isset($_POST['acao'])){
                if(Painel::equalsExisist($tb, ['name' => $_POST['name']], $id))
                    Painel::alert('error', 'Este nome de categoria ja existe');
                else{
                    $data = array_merge($_POST, ['slug' => Painel::generateSlug($_POST['name'])]);
                    if(Painel::update($tb, $data, ['id' => $id])){
                        Painel::alert('success','Serviço atualizado com sucesso.');
                        $sqlData = Painel::selectSingle($tb,['id' => $id]);
                    }else
                        Painel::alert('error','Campos vazios não são permitidos.');
                }
            }
        ?>

        <div class="form-group">
            <label for="name">Nome da Categoria: </label>
            <input type="text" id="name" name="name" value="<?php echo $sqlData['name'];?>" required />
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" name="acao" value="Atualizar" />
        </div><!--form-group-->
    </form>
</section><!--box-content-->