<?php require_once 'Side_Bar_home.php'; ?>
<?php require_once '../DB_Querys/home_Paginacao_Tabela.php'; ?>

<?php


$query = $dbDB->prepare("SELECT Visitante.* FROM Visitante LEFT JOIN aprovacao 
ON Visitante.id = aprovacao.id_visitante WHERE aprovacao.id_visitante IS NULL");
$query->execute();
$resultado = $query->fetchAll(PDO::FETCH_ASSOC);

// total de id pendentes
$total_Pendente =  $dbDB->prepare("SELECT v.id FROM Visitante v LEFT JOIN aprovacao a ON v.id = a.id_visitante
    WHERE a.id_visitante IS NULL OR (a.aprovado_reprovado IS NOT NULL AND a.aprovado_reprovado <> 'on')");
$total_Pendente->execute();
$total = $total_Pendente->fetchAll(PDO::FETCH_COLUMN);
$count_Pendente = count($total);

// Total de id aprovado
$count_aprovado = $dbDB->prepare("SELECT id_visitante FROM aprovacao WHERE aprovado_reprovado = 'on' AND id_visitante IS NOT NULL");
$count_aprovado->execute();
$ids_aprovados = $count_aprovado->fetchAll(PDO::FETCH_COLUMN);
?>

<div class=" d-flex flex-column col">

    <div class="d-flex justify-content-center mt-5">
        <div class="d-flex justify-content-start text-dark col-sm-10">
            <span class="titulo">
                Aprovar visitante
            </span>
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-center mb-5 mt-5">
        <div class="d-flex flex-row col-sm-10 justify-content-end">
            <div class="card-home-back justify-content-end shadow me-4">
                <div class="card-home-front p-3">
                    <p class="m-0 text-white titulo-card">Total de visitas pendentes: <?php echo $count_Pendente ?></p>
                </div>
            </div>
            <div class="card-home-back-success shadow ">
                <div class="card-home-front-success " data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <p class="m-0 text-white titulo-card p-2">Total de visitas aprovadas: <?php echo count($ids_aprovados) ?> </p>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12">
        <table class="d-flex align-items-center table-css flex-column col-sm-12">
            <thead class="">
                <tr class="thead-designer font-css-dark">
                    <th class="th-designer" scope="col">Nome</th>
                    <th class="th-designer" scope="col">Empresa </th>
                    <th class="th-designer" scope="col">Area da Visita</th>
                    <th class="th-designer" scope="col">Data da Visita</th>
                    <th class="th-designer">aprovar</th>
                    <th class="th-designer">enviar</th>
                </tr>
            </thead>
            <?php

            foreach ($resultado as $resultados) { ?>

                <tbody>
                    <tr class="listagem-back-blue mb-4">
                        <td class="listagem-front-white font-css" id="">
                            <span class="table-designer">
                                <a href="solicitacaoIndex.php?id=<?= $resultados['id'] ?>" class="font-id-css ">
                                    <?= $resultados['nome'] ?>
                                </a>
                            </span>
                            <span class="table-designer"><?= $resultados['empresa']; ?></span>
                            <span class="table-designer d-flex text-center"><?= $resultados['area_da_visita']; ?></span>
                            <span class="table-designer"><?= date('d/m/Y - H:i', strtotime($resultados['periodo_visita_de'])) ?></span>

                            <form action="../DB_Querys/aprovacao.php" method="POST" class="d-flex w-form">
                                <input type="hidden" name="id_visitante" value="<?= $resultados['id']; ?>">
                                <div class="d-flex align-items-center justify-content-center col-sm-6">
                                    <input type="checkbox" class="d-flex align-items-center justify-content-center" id="aprovado" name="aprovado"><span class="ms-3">Aprovar</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center col-sm-6 ">
                                    <input type="submit" class="btn btn-outline-info d-flex align-items-center justify-content-center" id="reprovado"></input>
                                </div>
                            </form>
                        </td>

                    </tr>
                </tbody>

            <?php   } ?>


        </table>
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
                        <thead class="thead-designer-front">
                            <tr class="thead-designer p-3 font-css-dark">
                                <th class="th-designer" scope="col">Nome</th>
                                <th class="th-designer" scope="col">Empresa </th>
                                <th class="th-designer" scope="col">Area da Visita</th>
                                <th class="th-designer" scope="col">Data da Visita</th>
                                <th class="th-designer" scope="col">Aprovação</th>
                            </tr>
                        </thead>
                        <?php
                        if (!empty($ids_aprovados)) {
                            $ids_str = implode(',', $ids_aprovados);
                            $query_total_aprovado = $dbDB->prepare("SELECT * FROM Visitante WHERE id IN ($ids_str)");
                            $query_total_aprovado->execute();
                            $query = $query_total_aprovado->fetchAll(PDO::FETCH_ASSOC);
                        
                            if (!empty($query)) {
                                foreach ($query as $querys) {
                                    ?>
                                    <tbody>
                                        <tr class="listagem-back-blue mb-4 bg-success ">
                                            <td class="listagem-front-white p-3 font-css border-success" id="">
                                                <span class="table-designer">
                                                    <a href="solicitacaoIndex.php?id=<?= $querys['id'] ?>" class="font-id-css ">
                                                        <?= $querys['nome'] ?>
                                                    </a>
                                                </span>
                                                <span class="table-designer"><?= $querys['empresa']; ?></span>
                                                <span class="table-designer "><?= $querys['area_da_visita']; ?></span>
                                                <span class="table-designer "><?= date('d/m/Y - H:i', strtotime($querys['periodo_visita_de'])) ?></span>
                                                <span class="table-designer ">Aprovado</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php
                                }
                            } else {
                                echo '<span id="font-css">Nenhuma visita foi aprovada ainda.</span>';
                            }
                        } else {
                            echo '<span id="font-css">Nenhuma visita foi aprovada ainda.</span>';
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