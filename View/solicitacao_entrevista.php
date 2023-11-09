<?php
require_once 'Side_Bar_home.php';
include_once('../BD_Conncetion/connection.php');
require_once('../DB_Querys/solicitacao_entrevista.php');
$dados = readSolicitacaoEntrevista($dbDB);
$dado =   paginacao($dbDB, $paginaAtual = 1, $limite = 5);
$paginas =  $_SESSION["paginas"];


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../View/login.php");
    exit;
}
?>

<div class="col d-flex justify-content-center">
    <div class="d-flex flex-column col align-items-center ">
        <div class="d-flex bg-transparent border-0 mt-5 mb-5 col-sm-10">
            <h2 class="text-title-css">
                Solicitação de entrevista
            </h2>
        </div>
        <div class=" d-flex col-sm-10 mb-5 bg-form-css align-items-center justify-content-around p-3 ">
            <div class="col-sm-10 d-flex justify-content-around">
                <div class="d-flex flex-column col-sm-5">
                    <label class="label-css" for="nome">Nome:</label>
                    <input type="text" id="nome" class="input-css" placeholder="Nome" require>

                    <label class="label-css" for="celular">Celular:</label>
                    <input type="text" id="celular" class="input-css" placeholder="Celular">
                </div>
                <div class="d-flex flex-column col-sm-5">
                    <label class="label-css" for="email">Email:</label>
                    <input type="email" id="email" class="input-css" placeholder="Email">

                    <label class="label-css" for="periodo_visita_de">Data da entrevista:</label>
                    <input type="datetime-local" id="periodo_visita_de" class="input-css">
                </div>
            </div>

            <div class="btn btn-success d-flex align-items-center" id="btnAdd">
                <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
            </div>
        </div>

        <div class="bg-form-css d-flex col-sm-10 ">
            <form action="../DB_Querys/solicitacao_entrevista.php" method="POST" class=" d-flex col-sm-12 justify-content-between ">
                <div class="d-flex flex-row justify-content-around p-3 col-sm-12">
                    <div class="d-flex flex-column col-sm-4" id="myForm"></div>

                    <div class="d-flex flex-column col-sm-4" id="myForm2"></div>

                    <div class=" d-flex align-items-center justify-content-around flex-column " id="remove-btn"></div>

                    <div class=" d-flex flex-row align-items-end justify-content-end col-sm-1">
                        <input class="btn btn-success  col-sm-12" type="submit" value="Enviar" id="btn-enviar" disabled>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-inline-flex gap-1 mt-5 col-sm-10">
            <div class="d-flex flex-row col-sm-10 justify-content-start">
                <div class="card-home-back-2 justify-content-end shadow me-4" id="cursor" >
                    <div class="card-home-front-2 p-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <p class="m-0 text-white titulo-card">Total de entrevistas cadastradas: <?php echo count($dados) ?> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse col-sm-10 mt-5 mb-5" id="collapseExample" data-bs-parent=".container">
            <table class="d-flex align-items-center table-css flex-column col-sm-12 table-fixed">
                <thead class="">
                    <tr class="thead-designer font-css font-css-dark">
                        <th class="th-designer">Nome</th>
                        <th class="th-designer">Celular</th>
                        <th class="th-designer">Email</th>
                        <th class="th-designer">Data da entrevista</th>

                    </tr>
                </thead>

                <?php
                foreach ($dado as $registros) { ?>
                    <tbody>
                        <tr class="listagem-back-blue mb-4">
                            <td class="listagem-front-white font-css ">
                                <span class="table-designer ">
                                    <?php echo $registros['nome']; ?>
                                </span>
                                <span class="table-designer">
                                    <?php echo $registros['celular'] ?>
                                </span>
                                <span class="table-designer">
                                    <?php echo $registros['email']; ?>
                                </span>
                                <span class="table-designer">
                                    <?php echo date('d/m/Y - H:i', strtotime($registros['data_entrevista'])) ?>
                                </span>
                            </td>
                        </tr>

                    </tbody>

                <?php } ?>
            </table>
            <div class="d-flex col-sm-12 justify-content-center mb-4">
                <div class="d-flex flex-row justify-content-end col-sm-9 align-items-center">
                    <a href="?paginaAtual=1" class="me-2 text-decoration-none  color-paginacao">Primeira</a>
                        <?php if ($paginaAtual > 1) : ?>
                            <a href="?paginaAtual=<?= $paginaAtual - 1 ?>">
                                <?php endif; ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                    <path d="M10 1L2 5.76191L10 11" stroke="#004159" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </a>

                            <div class="d-flex align-items-center justify-content-center circle-css">
                                <span><?= $paginaAtual ?></span>
                            </div>

                            <?php if ($paginaAtual < $paginas) : ?>
                                <div class="d-flex flex-row justify-content-center align-items-center pb-1 ">
                                    <a href="?paginaAtual=<?= $paginaAtual + 1 ?>">
                                        <?php endif; ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                            <path d="M1 11L9 6.23809L1 1" stroke="#004159" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </a>
                                </div>
                    <a href="?paginaAtual=<?= $paginas ?>" class="ms-2 text-decoration-none  color-paginacao">Ultima</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
if (isset($_SESSION['sucesso'])) {
?>
    <div class="alert position-absolute flash-message">
        <div class="flash-message-child p-4">
            <i class="fa-solid fa-circle-check" style="color: #08d415; font-size: 5rem;"></i>

            <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                <p class="font-flash-message">
                    Sucesso
                </p>
                <span class="font-css">
                    <?php
                    echo $_SESSION['sucesso'];
                    unset($_SESSION['sucesso']);
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


<script src="../Js/main.js" crossorigin="anonymous"></script>
<script src="../Js/dataTable.js" crossorigin="anonymous"></script>