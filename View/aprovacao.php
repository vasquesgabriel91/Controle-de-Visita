<?php require_once 'Side_Bar_home.php'; ?>
<?php require_once '../DB_Querys/home_Paginacao_Tabela.php'; ?>

<?php
    $paginaAtual = 1;
    $limite = 5;

    if(isset($_GET['paginaAtual'])) { 
        $paginaAtual = filter_input(INPUT_GET, "paginaAtual", FILTER_VALIDATE_INT);
    } else {
        $paginaAtual = 1;
    }

    if($paginaAtual){
        $inicio = ($paginaAtual * $limite) - $limite;
        
        // Consulta a tabela Visitante e devolve os resultados que nao são on e não são null e faz paginação 
        $consulta = $dbDB->prepare("SELECT v.id, v.nome, v.empresa, v.area_da_visita, v.periodo_visita_de FROM Visitante v LEFT JOIN aprovacao a ON v.id = a.id_visitante
        WHERE a.id_visitante IS NULL AND (a.aprovado_reprovado IS NULL OR a.aprovado_reprovado <> 'on')
        ORDER BY v.id OFFSET $inicio ROWS FETCH NEXT $limite ROWS ONLY");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $total_count = count($resultado);

        $registro = $dbDB->query("SELECT COUNT(id) as count FROM Visitante" )->fetch()["count"];
        $paginas = ceil($registro / $limite);
    }

    // total de id pendentes
    $total_Pendente =  $dbDB->prepare("SELECT v.id FROM Visitante v LEFT JOIN aprovacao a ON v.id = a.id_visitante
    WHERE a.id_visitante IS NULL OR (a.aprovado_reprovado IS NOT NULL AND a.aprovado_reprovado <> 'on')");
    $total_Pendente->execute();
    $total = $total_Pendente->fetchAll(PDO::FETCH_COLUMN);
    $count_Pendente = count($total);

    // Total de id aprovado
    $count_aprovado = $dbDB->prepare("SELECT id_visitante FROM aprovacao WHERE aprovado_reprovado = 'on'");
    $count_aprovado->execute();
    $ids_aprovados = $count_aprovado->fetchAll(PDO::FETCH_COLUMN);
?>

<div class=" d-flex flex-column col">

    <div class="d-flex justify-content-center mt-5">
        <div class="d-flex justify-content-start text-dark col-sm-10">
            <span class="titulo">
                Aprovar Visitante
            </span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-center mb-5 mt-5">
        <div class="d-flex flex-row col-sm-10 justify-content-end">
            <div class="card-home-back justify-content-end shadow me-4">
                <div class="card-home-front p-3">
                    <p class="m-0 text-white titulo-card" >Total de Visitas Pendentes: <?php echo $count_Pendente ?></p>
                </div>
            </div>
             <div class="card-home-back-success shadow ">
                <div class="card-home-front-success " data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <p class="m-0 text-white titulo-card">Total de Visitas Aprovadas: <?php echo count($ids_aprovados)?> </p>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="GET" class="d-flex justify-content-center">
        <div class="d-flex align-items-center col-sm-10 ps-4">
            <div class="d-flex align-items-center rounded-pill col-sm-2 bg-light border-radius-css">
                <input type="text" placeholder="Pesquisar" id="pesquisar" name="pesquisar" class="rounded-pill border-0 p-1 me-2 bg-light col-sm-9 focus-outline-none-css" >
                <button type="submit" class="border-0 bg-transparent">
                    <i class="fa-solid fa-magnifying-glass" style="color: #00b0f2;"> </i>
                </button>
            </div>
        </div>
    </form>
    <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12 ">
        <table class="d-flex align-items-center table-css flex-column col-sm-12 ">
            <thead class="col-sm-11 ">
                <tr class="d-flex flex-row justify-content-around align-items-center mb-4 font-css font-css-dark">
                    <th>Nome</th>
                    <th>Empresa </th>
                    <th>Telefone</th>
                    <th>Data de Visita</th>
                    <th>Aprovar</th>
                    <th>Enviar</th>
                </tr>
            </thead>
                <?php 
                    foreach ($resultado as $resultados) { ?>
                        <tr class="listagem-back-blue mb-4">
                            <td class="listagem-front-white font-css">
                                <span class=""><a href="solicitacaoIndex.php?>" class="font-id-css"><?= $resultados['nome']?></a> </span>
                                <span><?= $resultados['empresa']; ?></span>
                                <span><?= $resultados['area_da_visita']; ?></span>
                                <span><?= $resultados['periodo_visita_de']; ?></span>

                                <form action="../DB_Querys/aprovacao.php" method="POST" class="d-flex col-sm-3 justify-content-between">
                                    <input type="hidden" name="id_visitante" value="<?= $resultados['id']; ?>">
                                    <div class="d-flex align-items-center ">
                                        <input type="checkbox" class="d-flex align-items-center justify-content-center" id="aprovado" name="aprovado"><span class="ms-3">Aprovar</span>
                                    </div>
                                    <div class="d-flex align-items-center me-3 ">
                                        <input type="submit" class="btn btn-outline-info d-flex align-items-center justify-content-center"  id="reprovado" ></input>
                                    </div>
                                </form>

                            </td>    
                        </tr>
                <?php } ?>
        </table>

        <div class="d-flex col-sm-12 justify-content-center mb-4">
            <div class="d-flex flex-row justify-content-end col-sm-9 align-items-center">
                <a href="?paginaAtual=1" class="me-2 text-decoration-none  color-paginacao">Primeira</a>
                <?php if($paginaAtual>1):?>
                    <a href="?paginaAtual=<?=$paginaAtual-1 ?>"> 
                <?php endif;?> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                        <path d="M10 1L2 5.76191L10 11" stroke="#004159" stroke-width="2" stroke-linecap="round"/>
                    </svg> 
                </a>

                <div class="d-flex align-items-center justify-content-center circle-css">
                    <span><?= $paginaAtual ?></span>
                </div>

                <?php if($paginaAtual<$paginaAtual):?>
                    <a href="?paginaAtual=<?=$paginaAtual+1 ?>" > 
                <?php endif;?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                        <path d="M1 11L9 6.23809L1 1" stroke="#004159" stroke-width="2" stroke-linecap="round"/>
                    </svg> 
                </a>
                <a href="?paginaAtual=<?=$paginas?>" class="ms-2 text-decoration-none  color-paginacao">Ultima</a>
            </div>
        </div>

    </div>
  
    
</div>
<!-------------- Modal------------->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-css modal-dialog-css-success">
            <div class="d-flex flex-row justify-content-end col-sm-12">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content modal-content-css border-0 bg-transparent">
                <div class="modal-header modal-header-css border-0">
                    <h1 class="modal-title fs-5 font-css" id="exampleModalLabel">Total:</h1>
                </div>
                <div class="modal-body modal-body-css">
                <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12">
                    <table class="d-flex align-items-center table-css flex-column col-sm-12">
                        <thead class="col-sm-11 ">
                            <tr class="d-flex flex-row justify-content-around align-items-center mb-4 font-css font-css-dark">
                                    <th class="" scope="col">Id</th>
                                    <th class="" scope="col">Nome</th>
                                    <th class="" scope="col">Empresa </th>
                                    <th class="" scope="col">Area da Visita</th>
                                    <th class="" scope="col">Data da Visita</th>
                                    <th class="" scope="col">Aprovação</th>
                                </tr>
                        </thead>
                                <?php 
                                    if (!empty($ids_aprovados)) {
                                        $ids_str = implode(',', $ids_aprovados);
                                        $query_total_aprovado = $dbDB->prepare("SELECT * FROM Visitante WHERE id IN ($ids_str)");
                                        $query_total_aprovado->execute();
                                        $query = $query_total_aprovado->fetchAll(PDO::FETCH_ASSOC);
                                    } else {?>
                                        <span id="font-css">Nenhum aprovado encontrado</span>'
                                    <?php }
                                    if(isset($query)){
                                        foreach ($query as $querys) {   
                                    ?>
                                        <tbody>
                                        <tr class="listagem-back-green mb-4">
                                            <td class="listagem-front-white-green  font-css">
                                                    <a href="solicitacaoIndex.php?id=<?= $querys['id']; ?>" class="text-decoration-none">
                                                        <span class="font-id-css"><?= $querys['id']; ?></span>
                                                    </a>
                                                    <span ><?= $querys['nome']; ?></span>
                                                    <span ><?= $querys['empresa']; ?></span>
                                                    <span ><?= $querys ['area_da_visita']; ?></span>
                                                    <span ><?= $querys['periodo_visita_de']; ?></span>
                                                    <span  class="d-flex align-items-center justify-content-center" id="aprovado" name="aprovado">Aprovado</span>
                                            </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                            </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-danger col-sm-3" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>



    <?php
        if (isset($_SESSION['status'])) {
        ?>
            <div class="alert position-absolute flash-message">
                <div class="flash-message-child p-4">
                    
                    <i class="fa-solid fa-circle-check" style="color: #08d415; font-size: 5rem;"></i>
                    
                    <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                        <p class="font-flash-message">
                        Aprovado com sucesso
                        </p>
                        <span class="font-css text-center">
                            <?php
                                echo $_SESSION['status'];
                                unset($_SESSION['status']);
                            ?>
                        </span>
                    </div>
            
                    <div class="d-flex flex-row justify-content-center col-sm-7 mt-4">
                        <button type="submit" class="btn btn-danger col-sm-6" data-bs-dismiss="alert" aria-label="Close">Fechar</button>
                    </div>

                </div>
            </div>
        <?php
        }
    ?>

    
<?php
        if (isset($_SESSION['danger'])) {
        ?>
            <div class="alert position-absolute flash-message">
                <div class="flash-message-child p-4">
                    
                    <i class="fa-solid fa-circle-exclamation fa-shake " style="color: #fb1313; font-size: 5rem;"></i>
                    
                    <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                        <p class="font-flash-message">
                        Reprovado
                        </p>
                        <span class="font-css text-center">
                            <?php
                                echo $_SESSION['danger'];
                                unset($_SESSION['danger']);
                            ?>
                        </span>
                    </div>
            
                    <div class="d-flex flex-row justify-content-center col-sm-7 mt-4">
                        <button type="submit" class="btn btn-danger col-sm-6" data-bs-dismiss="alert" aria-label="Close">Fechar</button>
                    </div>

                </div>
            </div>
        <?php
        }
    ?>