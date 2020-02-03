<?php 
    $tb = 'tb_site.slides';
    $page = 'list-slides';
    $porPag = 5;

    if(isset($_GET['excluir'])){
        Site::verificaPermissaoAcao(1);
        $id = (int)$_GET['excluir'];
        Painel::deleteRegistro($tb, ['id' => $id], 'slide');
        Painel::redirect(INCLUDE_PATH_PANEL.$page);
    }else if(isset($_GET['order'])){
        Painel::orderItem($tb,$_GET['order'],$_GET['id']);
        Painel::cleanUrlJs(INCLUDE_PATH_PANEL.$page);
    }

    $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    // A partir de qual parametro se deve pegar
    $total = count(Painel::selectAll($tb,['id'])) / $porPag;
    $sqlResult = Painel::selectAll($tb, ['*'], null, 'order_id ASC', ($paginaAtual - 1) * $porPag, $porPag);
    $columns = mySQL::getColumnsName($tb);
?>

<section class="box-content b1">
    <h2><i class="fas fa-id-card-alt"></i> Slides cadastrados</h2>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <?php 
                        foreach($columns as $value){
                            if($value['COLUMN_NAME'] !== 'id' && $value['COLUMN_NAME'] !== 'order_id')
                                echo "<th>".ucfirst($value['COLUMN_NAME'])."</th>";
                        }
                    ?>
                    <th <?php Site::verificaPermissaoMenu(1); ?> >Editar</th>
                    <th <?php Site::verificaPermissaoMenu(1); ?> >Deletar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach($sqlResult as $value){
                        echo "<tr>";
                        foreach($value as $key => $col){
                            if(is_string($key) && $key !== 'id' && $key !== 'order_id'){
                                if($key == "slide"){
                                    echo "<td><img src='".INCLUDE_PATH_PANEL.'uploads/'.$value['slide']."' /></td>";
                                    continue;
                                }
                    ?>
                            <td><?php echo $col; ?></td>
                    <?php }} ?>

                        <td <?php Site::verificaPermissaoMenu(1); ?>><a class="btn-edit" href="<?php echo INCLUDE_PATH_PANEL.'edit-slides?id='.$value['id']; ?>"><i class="fas fa-edit"></i> Editar</a></td>
                        <td <?php Site::verificaPermissaoMenu(1); ?>><a class="btn-delete" href="<?php echo INCLUDE_PATH_PANEL.$page.'?excluir='.$value['id']; ?>"><i class="fas fa-trash-alt"></i> Excluir</a></td>
                        <td><div class="order-wrapper">
                            <a href="<?php echo INCLUDE_PATH_PANEL.$page.'?pagina='.$paginaAtual.'&order=up&id='.$value['id']; ?>"><i class="fas fa-angle-up"></i></a>
                            <a href="<?php echo INCLUDE_PATH_PANEL.$page.'?pagina='.$paginaAtual.'&order=down&id='.$value['id']; ?>"><i class="fas fa-angle-down"></i></a>
                        </div></td>
                        
                        <?php echo "</tr>"; ?>
                    <?php }?>
            </tbody>
        </table>

        <div class="paginacao">
            <?php
                for($i = 1; $i <= ceil($total);$i++){
                    if($i == $paginaAtual)
                        echo "<a class='active' href='".INCLUDE_PATH_PANEL.$page."?pagina=$i'>$i</a>";
                    else
                        echo "<a href='".INCLUDE_PATH_PANEL.$page."?pagina=$i'>$i</a>";
                }
            ?>
        </div>

    </div>
</section>