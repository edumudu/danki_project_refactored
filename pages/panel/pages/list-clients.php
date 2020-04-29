<?php 
    $tb = 'tb_admin.clientes';
    $page = 'list-clients';
    $porPag = 5;

    if(isset($_GET['order'])){
        Painel::orderItem($tb,$_GET['order'],$_GET['id']);
        Painel::cleanUrlJs(INCLUDE_PATH_PANEL.$page);
    }

    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    // A partir de qual parametro se deve pegar
    $total = count(Painel::selectAll($tb,['id'])) / $porPag;
    $sqlResult = Painel::selectAll($tb, ['*'], null, 'order_id ASC', ($paginaAtual - 1) * $porPag, $porPag);
    $columns = mySQL::getColumnsStats($tb);
    
?>

<section class="box-content b1">
    <h2><i class="fas fa-id-card-alt"></i> Clientes cadastrados</h2>
    <div class="busca">
        <h4><i class="fas fa-search"></i> Realizar uma busca</h4>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="search" placeholder="Procure por nome, email, cpf ou cnpj" />
            </div>
            <input type="submit" name="buscar" value="Buscar" class="btn-form" />
        </form>
    </div>

    <?php
        
        if(isset($_POST['buscar'])){
            $busca = $_POST['search'];
            $where = "WHERE `name` LIKE '%$busca%' OR `email` LIKE '%$busca%' OR `cpf_cnpj` LIKE '%$busca%'";
            $sql = mySQL::connect()->prepare(Painel::buildQuerySelect('tb_admin.clientes').' '.$where);
            $sql->execute();
            $sqlResult = $sql->fetchAll();

            echo '<div class="busca-result"><p>Foram encontrados '.count($sqlResult).' resultado(s).</p></div>';
        }

    ?>

    <div class="boxes">

        <?php foreach($sqlResult as $client) {?>

        <div class="box-single-wrapper" item_id="<?php echo $client['id']; ?>">
            <div class="box-single">
                <div class="top-box">
                    <?php if($client['img']){ ?>
                        <img src="<?php echo INCLUDE_PATH_PANEL.'uploads/'.$client['img']; ?>" alt="Imagem do cliente" title="Imagem do cliente" />
                    <?php }else{ ?>
                        <h2><i class="fas fa-user"></i></h2>
                    <?php }?>
                </div><!--top-box-->

                <div class="body-box">
                    <p><b><i class="fas fa-info-circle"></i> Nome do cliente: </b> <?php echo ucfirst($client['name']); ?></p>
                    <p><b><i class="fas fa-info-circle"></i> E-mail: </b> <?php echo $client['email']; ?> </p>
                    <p><b><i class="fas fa-info-circle"></i> Tipo: </b> <?php echo ucfirst($client['tipe']); ?></p>
                    <p><b><i class="fas fa-info-circle"></i> <?php echo $client['tipe'] == 'fisico' ? 'CPF' : 'CNPJ'; ?>: </b> <?php echo $client['cpf_cnpj']; ?> </p>
                </div><!--body-box-->

                <div class="box-action">
                    <a class="btn-edit" title="Editar" href="<?php echo INCLUDE_PATH_PANEL.'edit-client?id='.$client['id']; ?>"><i class="fas fa-edit"></i></a>
                    <a class="btn-delete" title="Excluir" href=""><i class="fas fa-trash-alt"></i></a>
                </div>
            </div><!--box-single-->
        </div><!--box-single-wrapper-->

        <?php }?> 
    </div><!--boxes-->

    </div>
</section>