<?php
    $categoriaSlug = $thisUrl[1];
    if(!painel::equalsExisist('tb_site.categorias',['slug' => $categoriaSlug]))
        Painel::redirect(INCLUDE_PATH.'news');
    
    $categoria_info = Painel::selectSingle('tb_site.categorias',['slug' => $categoriaSlug]);
    $thisSlug = $thisUrl[2];
    $notice = Painel::selectSingle('tb_site.noticias',['slug' => $thisSlug, 'categoria_ref' => $categoria_info['id']]);
    if($notice == '')
        Painel::redirect(INCLUDE_PATH.'news');
?>

<section class="news-single">
    <div class="container">
        <header>
            <h1><i class="far fa-calendar-alt"></i> <?php echo $notice['date'].' - '.$notice['title'];?></h1>
        </header>
        <article>
            <?php echo $notice['conteudo'];?>
        </article>
    </div>
</section>