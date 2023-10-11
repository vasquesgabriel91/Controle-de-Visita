<?php require_once 'Side_Bar_home.php'; ?>
<?php require_once '../DB_Querys/home_Paginacao_Tabela.php'; ?>

<?php
// Faz uma Consulta do Total de visitas Cadastradas
$Count_Total = $dbDB->prepare("SELECT id FROM Visitante ORDER BY id DESC");
$Count_Total->execute();
$total = $Count_Total->fetchAll(PDO::FETCH_COLUMN);

//Visitas por Data atual 
$hoje = date('Y-m-d'); // Formato: Ano-Mês-Dia
$visitas_Hoje = $dbDB->prepare("SELECT * FROM Visitante WHERE CONVERT(DATE, periodo_visita_de) = :hoje ORDER BY id DESC");
$visitas_Hoje->bindValue(':hoje', $hoje, PDO::PARAM_STR);
$visitas_Hoje->execute();
$resultadosHoje = $visitas_Hoje->fetchAll(PDO::FETCH_ASSOC);
?>

<div class=" d-flex flex-column col">

    <div class="d-flex justify-content-center mt-5">
        <div class="d-flex justify-content-start text-dark col-sm-10">
            <span class="titulo">
                Consulta Visitante
            </span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-center mb-5 mt-5">
        <div class="d-flex flex-row col-sm-10 justify-content-end">

            <div class="card-home-back justify-content-end shadow me-4 hover bg-warning" id="back-yellow">
                <div class="card-home-front p-3 " id="cursor" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <p class="m-0 text-white titulo-card">Visitas marcada para Hoje: <?php echo $hoje ?> </p>
                </div>
            </div>

            <div class="card-home-back justify-content-end shadow me-4">
                <div class="card-home-front p-3" >
                    <p class="m-0 text-white titulo-card" >Total de Visitas Cadastradas: <?php echo count($total)?> </p>
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
    
    <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12">
        <table class="d-flex align-items-center table-css flex-column col-sm-12">
            <thead class="col-sm-11 ">
                <tr class="d-flex flex-row justify-content-around align-items-center mb-4 font-css font-css-dark">
                    <th>Nome</th>
                    <th>Empresa </th>
                    <th>Telefone</th>
                    <th>Area da Visita</th>
                    <th>Data de Visita</th>
                    <?php
                    // Verificar se o usuário tem permissão de acesso à seção, Se o usuário for diretor ou gestor, eles têm permissão de acesso
                        if (isset($acesso)) { ?>
                            <th>Editar</th>
                            <th>Deletar</th>
                        <?php
                        } else {
                            echo "";
                        }
                    ?>
                </tr>
            </thead>             
            <?php   

                foreach ($resultado as $resultados) { ?>
                    <tbody>
                    <tr class="listagem-back-blue mb-4">
                            <td class="listagem-front-white font-css">
                            <?php
                                // Verificar se o usuário tem permissão de acesso à seção, Se o usuário for diretor ou gestor, eles têm permissão de acesso
                                if (!isset($acesso)) { ?>
                                    <div class="d-flex justify-content-between font-css col-sm-12  ps-3 pe-5">
                                        <span><?= $resultados['nome']; ?></span>
                                        <span><?= $resultados['empresa']; ?></span>
                                        <span><?= $resultados['area_da_visita']; ?></span>
                                        <span><?= $resultados['periodo_visita_de']; ?></span>
                                    </div>
                                <?php
                                } else { ?>
                                    <div class="d-flex justify-content-between width-listagem-front-white font-css">
                                        <span class=""><a href="solicitacaoIndex.php?id=<?= $resultados['id']?>" class="font-id-css"><?= $resultados['nome']?></a> </span>
                                        <span><?= $resultados['empresa']; ?></span>
                                        <span><?= $resultados['celular']; ?></span>
                                        <span> <?= $resultados['area_da_visita']; ?></span>
                                        <span><?= $resultados['periodo_visita_de']; ?></span>
                                    </div>
                                <?php
                                }
                            ?>
                        
                            <?php
                                // Verificar se o usuário tem permissão de acesso à seção, Se o usuário for diretor ou gestor, eles têm permissão de acesso
                                if (isset($acesso)) { ?>
                                    <div class="editar-deletar  d-flex justify-content-between ">
                                        <a href="solicitacaoIndex.php?id=<?= $resultados['id']; ?>" class="btn btn-success text-white">Editar</a>
                                        <a href="../DB_Querys/solicitacaoDelete.php?id=<?= $resultados['id'];?>" class="btn btn-danger text-white text-decoration-none ">Excluir</a>
                                    </div>
                                <?php
                                } else {
                                    echo "";
                                }
                            ?>
                        </td>    
                    </tr>

                    </tbody>

                  
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

                <?php if($paginaAtual<$paginas):?>
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

<?php
    $id_aprovado = null; // Inicialize a variável com um valor padrão

    if (isset($_SESSION['Erro_Para_deletar_Aprovados'])) {
        
    ?>
    <div class="alert position-absolute flash-message">

        <div class="flash-message-child p-4">
            <i class="fa-solid fa-circle-exclamation fa-shake " style="color: #fb1313; font-size: 5rem;"></i>

            <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                <p class="font-flash-message">
                    Tem certeza?
                </p>
                <span class="font-css">
                    <?php
                           
                        echo $_SESSION['Erro_Para_deletar_Aprovados'];
                        
                        unset($_SESSION['Erro_Para_deletar_Aprovados']);
                    ?>
                </span>
            </div>
          
            <div class="d-flex flex-row justify-content-around col-sm-7 mt-4">
                <button type="submit" class="btn btn-danger col-sm-5" data-bs-dismiss="alert" aria-label="Close">Cancelar</button>
                <form action="../DB_Querys/solicitacaoDelete.php" method="GET" class="col-sm-5">
                        <input type="submit" value="Apagar" name="id_aprovado" class="col-sm-12  btn btn-success" >
                </form>
            </div>
        </div>
    </div>

    <?php
    }
?>

<?php
    if (isset($_SESSION['deletar_Visitas'])) {
        
    ?>
    <div class="alert position-absolute flash-message">

        <div class="flash-message-child p-4">
            <i class="fa-solid fa-circle-exclamation fa-shake " style="color: #fb1313; font-size: 5rem;"></i>

            <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                <p class="font-flash-message">
                    Tem certeza?
                </p>
                <span class="font-css">
                    <?php
                           
                        echo $_SESSION['deletar_Visitas'];
                        
                        unset($_SESSION['deletar_Visitas']);
                    ?>
                </span>
            </div>
          
            <div class="d-flex flex-row justify-content-around col-sm-7 mt-4">
                <button type="submit" class="btn btn-danger col-sm-5" data-bs-dismiss="alert" aria-label="Close">Cancelar</button>
                <form action="../DB_Querys/solicitacaoDelete.php" method="GET" class="col-sm-5">
                        <input type="submit" value="Apagar" name="excluir_Registro" class="col-sm-12  btn btn-success" >
                </form>
            </div>
        </div>
    </div>

    <?php
    }
?>



<?php
    if (isset($_SESSION['deletado'])) {
    ?>
    <div class="alert position-absolute flash-message">
        <div class="flash-message-child p-4">
        <i class="fa-solid fa-circle-check" style="color: #08d415; font-size: 5rem;"></i>

            <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                <p class="font-flash-message">
                    Deletado
                </p>
                <span class="font-css">
                    <?php
                        echo $_SESSION['deletado'];
                        unset($_SESSION['deletado']);
                    ?>
                </span>
            </div>
       
            <div class="d-flex flex-row justify-content-around col-sm-7 mt-4">
                <button type="submit" class="btn btn-danger col-sm-5" data-bs-dismiss="alert" aria-label="Close">Fechar</button>
            </div>
        </div>
    </div>

    <?php
    }
?>


<?php
    if (isset($_SESSION['atualizado_sucesso'])) {
    ?>
    <div class="alert position-absolute flash-message">
        <div class="flash-message-child p-4">
            
            <i class="fa-solid fa-circle-check" style="color: #08d415; font-size: 5rem;"></i>
            
            <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                <p class="font-flash-message">
                   Atualizado com Sucesso
                </p>
                <span class="font-css text-center">
                    <?php
                        echo $_SESSION['atualizado_sucesso'];
                        unset($_SESSION['atualizado_sucesso']);
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

<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-css modal-dialog-css-success border-warning" id="modal-warning">
            <div class="d-flex flex-row justify-content-end col-sm-12">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content modal-content-css border-0 bg-transparent">
                <div class="modal-header modal-header-css border-0">
                    <h1 class="modal-title fs-5 font-css" id="exampleModalLabel"> Total de visitas para hoje: <strong><?php echo count($resultadosHoje)?></strong> </h1>
                </div>
                <div class="modal-body modal-body-css">
                <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12">
                    <table class="d-flex align-items-center table-css flex-column col-sm-12">
                        <thead class="col-sm-11 ">
                            <tr class="d-flex flex-row justify-content-around align-items-center mb-4 font-css font-css-dark">
                                    <th class="" scope="col">Nome</th>
                                    <th class="" scope="col">Empresa </th>
                                    <th class="" scope="col">Area da Visita</th>
                                    <th class="" scope="col">Data da Visita</th>
                                </tr>
                        </thead>
                                <?php 
                                
                                    foreach ($resultadosHoje as $Hoje) {   
                                    ?>
                                     <tbody>
                                        <tr class="listagem-back-blue mb-4 bg-warning " id="cursor" >
                                            <td class="listagem-front-white font-css border-warning"  id="">
                                                <span class=""><a href="solicitacaoIndex.php?id=<?= $Hoje['id']?>" class="font-id-css"><?= $Hoje['nome']?></a> </span>
                                                <span><?= $Hoje['empresa']; ?></span>
                                                <span><?= $Hoje ['area_da_visita']; ?></span>
                                                <span><?= $Hoje['periodo_visita_de']; ?></span>
                                            </td>
                                        </tr>
                                     </tbody>
                                        
                             <?php   } ?>
                               
                                    
                            </table>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-danger col-sm-3" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>