<?php
require_once './BD_Conncetion/connection.php';
require_once './Toten_Token/View/Side_Bar_Toten.php';


$hoje = date('Y-m-d'); // Formato: Ano-Mês-Dia
$visitas_Hoje = $dbDB->prepare("SELECT * FROM Visitante WHERE CONVERT(DATE, periodo_visita_de) = :hoje ORDER BY id");
$visitas_Hoje->bindValue(':hoje', $hoje, PDO::PARAM_STR);
$visitas_Hoje->execute();
$resultadosHoje = $visitas_Hoje->fetchAll(PDO::FETCH_ASSOC);

?>


<body class=" d-flex flex-row">
    <div class=" d-flex flex-column col">

        <div class="d-flex justify-content-center mt-5">
            <div class="d-flex justify-content-start text-dark col-sm-10 justify-content-between align-items-center ">
                <span class="titulo">
                    Consultar Visita:
                </span>
                <span>
                    <a href="../Controle-de-Visita-FullStack/View/home.php" id="btn-primary" class=" text-decoration-none btn btn-primary font-css" role="button">Painel Administrativo</a>
                </span>
            </div>
        </div>

        <div class="col-sm-12  d-flex justify-content-center mt-5">
            <div class="d-flex flex-column col-sm-12 d-flex justify-content-center align-items-center">

                <span class="titulo"> Digite seu Token de confirmação</span>

                <div class="d-flex align-items-center justify-content-center mt-5 col-sm-12">
                    <div class="col-sm-10 align-items-center justify-content-center">
                        <table id="myTable" class=" hover row-border order-column ">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Empresa</th>
                                    <th>Celular</th>
                                    <th>Presença</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($resultadosHoje as $consulta) {
                                ?>
                                    <tr>
                                        <td><?= $consulta['nome']; ?></td>
                                        <td><?= $consulta['empresa']; ?></td>
                                        <td><?= $consulta['celular']; ?></td>
                                        <td data-bs-toggle="modal" data-bs-target="#exampleModal<?= $consulta['id']; ?>">
                                            <a class="btn btn-info  font-id-css">
                                                Confirmar
                                            </a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="exampleModal<?= $consulta['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog p-3">
                                            <div class="modal-content modal-content-css border-0 bg-transparent col-sm-10">
                                                <div class=" col-sm-12 ">
                                                    <div class="d-flex flex-column align-items-center justify-content-center flash-message-child p-1 col-sm-12 mt-5 ">
                                                        <i class="fa-solid fa-circle-check" style="color: #08d415; font-size: 5rem;"></i>

                                                        <div class="d-flex flex-column justify-content-between align-items-center col-sm-12 mt-4">
                                                            <p class="font-flash-message">
                                                                Digite seu token
                                                            </p>

                                                            <form action="../Controle-de-Visita-FullStack/Toten_Token/DB_Query_Portaria_Toten/portaria.php?id=<?= $consulta['id'] ?>" method="POST" class="col-sm-11 mt-1 mb-3">
                                                                <div class="d-flex flex-column align-items-center col-sm-12">
                                                                    <div class="d-flex align-items-center justify-content-between rounded-pill col-sm-12 bg-light border-radius-css">
                                                                        <input type="text" autocomplete="off" placeholder="Pesquisar" id="token" name="token" class="input rounded-pill border-0 p-1 me-2 bg-light col-sm-10 focus-outline-none-css">
                                                                        <button type="submit" class="border-0 bg-transparent d-flex flex-row align-items-center justify-content-end col-sm-1 me-3 rounded-pill">
                                                                            <i class="fa-solid fa-magnifying-glass me-3" style="color: #00b0f2;"></i>
                                                                            <span class="font-css">PESQUISAR</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="simple-keyboard mt-3"></div>

                                                                    <div class="font-css text-center d-flex co-sm-12 justify-content-between p-3 mt-3">
                                                                        <span class="table-designer">
                                                                            <input type="submit" value="Enviar" class="btn btn-info"> </span>
                                                                        </span>
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                                                                        </div>
                                                                    </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php   } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>


<?php
if (isset($_SESSION['visita_confirmada'])) {
?>
    <div class="alert position-absolute flash-message">
        <div class="flash-message-child p-4">
            <i class="fa-solid fa-circle-exclamation fa-shake" style="color: #fb1313; font-size: 5rem;"></i>
            <div class="d-flex flex-column justify-content-between align-items-center mt-4">

                <?php
                if ($_SESSION['visita_confirmada'] == "Você está tentando confirmar uma visita que não é sua ou o token está incorreto") {
                ?>

                    <p class="font-flash-message" id="font-flash-message">
                        Algo deu errado
                    </p>

                <?php
                } else {
                ?>

                    <p class="font-flash-message" id="font-flash-message">
                        Já confirmamos sua visita.
                    </p>

                <?php
                }
                ?>

                <span class="font-css" id="">
                    <?php
                    echo $_SESSION['visita_confirmada'];
                    unset($_SESSION['visita_confirmada']);
                    ?>
                </span>
            </div>
            <div class="d-flex flex-row justify-content-around col-sm-7 mt-4">
                <button type="submit" class="btn btn-danger col-sm-5" data-bs-dismiss="alert" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
<?php
}
?>

<?php
if (isset($_SESSION['MensagemPortaria'])) {
?>
    <div class="alert position-absolute flash-message">
        <div class="flash-message-child p-4">

            <i class="fa-solid fa-circle-check" style="color: #08d415; font-size: 5rem;"></i>

            <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                <p class="font-flash-message">
                    Recebido com sucesso
                </p>
                <span class="font-css text-center">
                    <?php
                    echo $_SESSION['MensagemPortaria'];
                    unset($_SESSION['MensagemPortaria']);
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


<script src="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/index.js"></script>
<script src="../Controle-de-Visita-FullStack/Toten_Token/JS/main.js"></script>
<script src="../Controle-de-Visita-FullStack/Js/dataTable.js" crossorigin="anonymous"></script>