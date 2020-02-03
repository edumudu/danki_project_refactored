<?php
    $thisUrl = explode('/',$_GET['url']);
    $porPag = 10;
    $pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

    if(!isset($thisUrl[2])){

        $categoria = isset($thisUrl[1]) ? Painel::selectSingle('tb_site.categorias',['slug' => $thisUrl[1]]) : null;

        $query = Painel::buildQuerySelect('tb_site.noticias');
        if($categoria['name'] != '')
            $query .= " WHERE categoria_ref = $categoria[id]";

        if(isset($_POST['buscar'])){
            $busca = '%'.$_POST['parametro'].'%';
            if(strstr($query, 'WHERE') !== false)
                $query .= " AND `title` LIKE :busca ";
            else
                $query .= " WHERE `title` LIKE :busca ";
            
        }
        
        $noticias = mySQL::connect()->prepare($query.' ORDER BY `date` DESC LIMIT :start, :limit');
        
        $totalPaginas = mySQL::connect()->prepare($query);
        if(isset($busca))
            $totalPaginas->execute(['busca' => $busca]);
        else
            $totalPaginas->execute();
        $totalPaginas = ceil($totalPaginas->rowCount() / $porPag);
        if($pagina > $totalPaginas)
            $pagina = 1;
        $start = ($pagina - 1) * $porPag;

        $noticias->bindParam(':start',$start, PDO::PARAM_INT);
        $noticias->bindParam(':limit',$porPag, PDO::PARAM_INT);
        if(isset($busca))
            $noticias->bindParam(':busca', $busca);
        $noticias->execute();
        $noticias = $noticias->fetchAll();        
?>  

<section class="header-noticias">
    <div class="container">
        <h2><i class="far fa-bell"></i></h2>
        <h2>Aconpanhe as ultimas <b>noticias do portal</b></h2>
    </div>
</section>

<section class="container-portal">
    <div class="container">
        <aside> 
            <div class="box-content-sidebar">
                <h3><i class="fas fa-search"></i> Realizar uma busca:</h3>
                <form method="POST">
                    <input type="text" name="parametro" placeholder="O que deseja procurar?" required >
                    <input type="submit" name="buscar" value="pesquisar" />
                </form>
            </div><!--box-content-sizebar-->

            <div class="box-content-sidebar">
                <h3><i class="fas fa-list-ul"></i> Selecione a categoria:</h3>
                <form>
                    <select name="categoria">
                        <option value="" selected>Todas as categorias</option>
                        <?php foreach(Painel::selectAll('tb_site.categorias',['*'],null, 'order_id ASC') as $value){?>
                            <option <?php if($value['slug'] == @$thisUrl[1]) echo "selected";?> value="<?php echo $value['slug'];?>"><?php echo ucfirst($value['name']);?></option>
                        <?php }?>
                    </select>
                </form>
            </div><!--box-content-sizebar-->

            <div class="box-content-sidebar">
                <h3><i class="fas fa-user"></i> Sobre o autor:</h3>
                <div class="autor-box-portal">
                    <img src="<?php echo INCLUDE_PATH;?>images/pp.jpg" alt="author"/>
                    <div class="text-autor-portal">
                        <?php $info = Painel::selectSingle('tb_site.config',['id' => 1]);?>
                        <h3><?php echo $info['name_author']; ?></h3>
                        <p><?php 
                            echo substr($info['descricao'], 0, 500);
                            echo strlen($info['descricao']) >= 500 ? '...' : '';
                            ?></p>
                    </div>
                </div>
            </div><!--box-content-sizebar-->
        </aside>

        <main>
            <div class="header-content-portal">
                <?php
                    if(!isset($_POST['parametro'])){
                        if($categoria['name'] == ''){
                            echo "<h2>Vizualizando todas as noticias</h2>";
                        }else{
                            echo "<h2>Vizualizando noticias em <span>$categoria[name]</span></h2>";
                        }
                    }else
                        echo "<h2>Vizualizando resultado da busca por <span>$_POST[parametro]</span></h2>";
                ?>
            </div>

            <?php
                foreach($noticias as $value){
                    $categoriaSlug = Painel::selectSingle('tb_site.categorias',['id' => $value['categoria_ref']])['slug'];
            ?>

                <div class="box-single-content">
                    <h2><?php echo date('d-m-Y',strtotime($value['date']))." - $value[title]";?></h2>
                    <p>
                        <?php echo substr(strip_tags($value['conteudo']),0 , 500).'...';?>
                    </p>
                    <a href="<?php echo INCLUDE_PATH?>news/<?php echo "$categoriaSlug/$value[slug]"?>">Leia Mais</a>
                </div><!--box-sigle-content-->

            <?php }?>

            <div class="paginacao">
                <?php                    
                    for($i = 1; $i <= $totalPaginas; $i++){
                        if($i == $pagina)
                            echo '<a class="active" href="'.INCLUDE_PATH.'news/'.$categoria['slug'].'?pag='.$i.'">'.$i.'</a>';
                        else
                            echo '<a href="'.INCLUDE_PATH.'news/'.$categoria['slug'].'?pag='.$i.'">'.$i.'</a>';
                    }
                ?>
            </div>
        </main>
    </div>
</section>

<?php }else{
    include 'news_single.php';
}?>