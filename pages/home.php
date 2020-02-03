<section class="banner-main">
        <div class="overlay"></div>

        <div class="slider">
            <?php
                $slides = Painel::selectAll('tb_site.slides', ['name', 'slide'], null, 'order_id ASC', 0, 3);
                foreach($slides as $value){
            ?>
                <!--title e alt otimizao para SEO-->
                <div class="slide-img" style="background-image: url('<?php echo INCLUDE_PATH_PANEL.'uploads/'.$value['slide'];?>');"></div>
            <?php }?>
            <div class="bullets"></div>
        </div>

        <div class="container flex center">
            <form method="POST" class="ajax-form">
                <h2>Qual o seu melhor e-mail?</h2>
                <input type="email" name="email" required />
                <input type="submit" name="acao" value="Cadastrar" />
            </form>
        </div>
    </section><!--banner-main-->

    <section id="sobre" class="descricao-author">
        <div class="container flex space">
            <div class="c2">
                <h2><?php echo $infoSite['name_author']; ?></h2>
                <p><?php echo $infoSite['descricao'];?></p>
            </div>

            <div class="c2">
                <img src="<?php echo INCLUDE_PATH;?>images/pp.jpg" />
            </div>
        </div>
    </section><!--descricao-author-->

    <section id="servicos" class="especialiades">
        <div class="container">
            <h2 class="title">Especialidade</h2>
            <div class="content flex">
                <div class="box-especialidade c3">
                    <h2><i class="<?php echo $infoSite['icone_1']; ?>"></i></h2>
                    <h3>CSS3</h3>
                    <p>
                        <?php echo $infoSite['descricao_1']; ?>
                    </p>
                </div><!--box-especialidade-->

                <div class="box-especialidade c3">
                    <h2><i class="<?php echo $infoSite['icone_2']; ?>"></i></h2>
                    <h3>HTML5</h3>
                    <p>
                        <?php echo $infoSite['descricao_2']; ?>
                    </p>
                </div><!--box-especialidade-->

                <div class="box-especialidade c3">
                    <h2><i class="<?php echo $infoSite['icone_3']; ?>"></i></h2>
                    <h3>Javascript</h3>
                    <p>
                        <?php echo $infoSite['descricao_3']; ?>
                    </p>
                </div><!--box-especialidade-->
            </div><!--content-->
        </div><!--container-->
    </section><!--especialidades-->

<section class="extras">
<div class="container">
    <div class="depoimentos flex">
        <div class="c2">
            <h2 class="title">Depoimentos dos nossos clientes</h2>

            <?php
                $sql = mySQL::connect()->prepare("SELECT * FROM `tb_site.depoimentos` ORDER BY order_id ASC LIMIT 3");
                $sql->execute();
                $depoimentos = $sql->fetchAll();

                foreach($depoimentos as $value){
            ?>
            <div class="depoimento-single">
                <p>
                " <?php echo $value['depoimento'];?> "
                </p>
                <p class="author"><?php echo $value['name']; ?> - <?php echo $value['date'];?></p>
            </div>
            <?php }?>
        </div>

        <div class="c2">
            <h2 class="title">Serviços</h2>
            <ul>
                <?php 
                    $sql = mySQL::connect()->query("SELECT `servico` FROM `tb_site.servicos` ORDER BY `order_id` ASC LIMIT 5");
                    foreach($sql->fetchAll() as $value){
                ?>
                    <li><?php echo $value['servico']; ?></li>
                <?php }?>
            </ul>
        </div>
    </div><!--flex-depoimentos-->
</div><!--container-->

</section><!--extras-->