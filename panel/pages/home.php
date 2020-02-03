<?php 
    $usuariosOnline = Usuario::listUsersOnline();
    $usuariosCadastrados = Painel::selectAll('tb_admin.users');
    $totalVisitas = count(Painel::selectAll('tb_admin.visitas'));
    $visitasHoje = count(Painel::selectAll('tb_admin.visitas', ['id'], ['dia' => date('Y-m-d')]));
?>

<section class="box-content b1">
    <h2><i class="fas fa-home"></i> Painel de controle - <?php echo NOME_EMPRESA; ?></h2>

    <div class="box-metricas">
        <div class="box-metricas-single">
            <div class="box-metricas-wrapper">
                <h2>Usuarios online</h2>
                <p><?php echo count($usuariosOnline);?></p>
            </div>
        </div><!--box-metricas-single-->

        <div class="box-metricas-single">
            <div class="box-metricas-wrapper">
                <h2>Total de visitas</h2>
                <p><?php echo $totalVisitas;?></p>
            </div>
        </div><!--box-metricas-single-->

        <div class="box-metricas-single">
            <div class="box-metricas-wrapper">
                <h2>Visitas Hoje</h2>
                <p><?php echo $visitasHoje;?></p>
            </div>
        </div><!--box-metricas-single-->
    </div><!--box-mretricas-->
</section><!--box-content-->

<section class="box-content b2">
    <h2><i class="fas fa-rocket"></i> Usuarios Online no Site</h2>
    <div class="table-responsive">
        <div class="row">
            <div class="col">
                <span>IP</span>
            </div><!--col-->
            <div class="col">
                <span>Última ação</span>
            </div><!--col-->
        </div><!--row-->

        <?php 
            foreach($usuariosOnline as $value){
        ?>

        <div class="row">
            <div class="col">
                <span><?php echo $value['ip'];?></span>
            </div><!--col-->
            <div class="col">
                <span><?php echo date('d/m/Y H:i:s',strtotime($value['ultima_acao']));?></span>
            </div><!--col-->
        </div><!--row-->

        <?php }?>
    </div>
</section>

<section class="box-content b2">
    <h2><i class="fas fa-rocket"></i> Usuarios Cadastrados no Painel</h2>
    <div class="table-responsive">
        <div class="row">
            <div class="col">
                <span>Usuario</span>
            </div><!--col-->
            <div class="col">
                <span>Nome</span>
            </div><!--col-->
            <div class="col">
                <span>Cargo</span>
            </div><!--col-->
        </div><!--row-->

        <?php 
            foreach($usuariosCadastrados as $value){
        ?>

        <div class="row">
            <div class="col">
                <span><?php echo $value['user'];?></span>
            </div><!--col-->
            <div class="col">
                <span><?php echo $value['name'];?></span>
            </div><!--col-->
            <div class="col">
                <span><?php echo getCargo($value['cargo']);?></span>
            </div><!--col-->
        </div><!--row-->

        <?php }?>
    </div>
</section>
