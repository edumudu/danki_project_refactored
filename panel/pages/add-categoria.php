<?php
    $tb = 'tb_site.categorias';
    $page = 'add-categoria';

?>

<section class="box-content b1">
    <h2><i class="fas fa-plus-square"></i> Cadastrar nova categoria</h2>

    <form method="POST">

        <?php
            if(isset($_POST['acao'])){
                $name = $_POST['name'];

                if($name){
                    if(Painel::equalsExisist($tb, ['name' => $_POST['name']]))
                        Painel::alert('error', 'Este nome de categoria ja existe');
                    else{
                        $data = array_merge($_POST, ["slug" => Painel::generateSlug($name)]);
                        if(Painel::insert($tb, $data, true))
                            Painel::alert('success','Categoria cadastrada com sucesso.');
                    }
                }else
                    Painel::alert('error', 'Campos vazios não são permitidos.');
            }
        ?>

        <div class="form-group">
            <label for="name">Nome da categoria: </label>
            <input type="text" id="name" name="name" required />
        </div><!--form-group-->

        <div class="form-group">
            <input class="btn-form" type="submit" value="Adicionar" name="acao"/>
        </div><!--form-group-->
    </form>
</section>