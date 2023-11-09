<?php
require_once './BD_Conncetion/connection.php';
require_once './Toten_Token/View/Side_Bar_Toten.php';

// $paginaAtual = 1;
// $limite = 5;

// if (isset($_GET['paginaAtual'])) { 
//     $paginaAtual = filter_input(INPUT_GET, "paginaAtual", FILTER_VALIDATE_INT);
// } else {
//     $paginaAtual = 1;
// }

// if ($paginaAtual) {
//     $hoje = date('Y-m-d'); // Formato: Ano-Mês-Dia

//     $inicio = ($paginaAtual * $limite) - $limite;

//     $consulta_data = $dbDB->prepare("SELECT * FROM Visitante WHERE CONVERT(DATE, periodo_visita_de) = :hoje ORDER BY id OFFSET $inicio ROWS FETCH NEXT $limite ROWS ONLY");
//     $consulta_data->bindParam(':hoje', $hoje);
//     $consulta_data->execute();
//     $resultado_data = $consulta_data->fetchAll(PDO::FETCH_ASSOC);

//     $consulta_count_data = $dbDB->prepare("SELECT COUNT(*) as count FROM Visitante WHERE CONVERT(DATE, periodo_visita_de) = :hoje");
//     $consulta_count_data->bindParam(':hoje', $hoje);
//     $consulta_count_data->execute();
//     $totalRegistros = $consulta_count_data->fetchColumn();
//     $paginas = ceil($totalRegistros / $limite);
// }
// $hoje = date('Y-m-d');
$consulta_data = $dbDB->prepare("SELECT * FROM Visitante ORDER BY id ASC");
$consulta_data->execute();
$resultado_data = $consulta_data->fetchAll(PDO::FETCH_ASSOC);


?>


<body class=" d-flex flex-row">
    <div class=" d-flex flex-column col">

        <div class="d-flex justify-content-center mt-5">
            <div class="d-flex justify-content-start text-dark col-sm-10 justify-content-between align-items-center ">
                <span class="titulo">
                    Consultar Visita:
                </span>
                <span>
                    <a href="../Controle-de-Visita-FullStack/View/home.php" id="btn-primary" class=" text-decoration-none btn btn-primary font-css" role="button">Painél Administrativo</a>
                </span>
            </div>
        </div>

        <div class="col-sm-12  d-flex justify-content-center mt-5">
            <div class="d-flex flex-column col-sm-12 d-flex justify-content-center align-items-center">

                <span class="titulo"> Digite seu Token de confirmação</span>
                <form action="" method="post" class="col-sm-11 mt-5">
                    <div class="d-flex align-items-center justify-content-between rounded-pill col-sm-12 bg-light border-radius-css">
                        <input type="text" autocomplete="off" placeholder="Pesquisar" id="pesquisar" name="token" class="input rounded-pill border-0 p-1 me-2 bg-light col-sm-10 focus-outline-none-css">
                        <button type="submit" class="border-0 bg-transparent d-flex flex-row align-items-center justify-content-end col-sm-1 me-3 rounded-pill">
                            <i class="fa-solid fa-magnifying-glass me-3" style="color: #00b0f2;"> </i>
                            <span class="font-css">PESQUISAR</span>
                        </button>
                    </div>
                    <div class="simple-keyboard "></div>

                </form>

                <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12">
                    <table class="d-flex align-items-center table-css flex-column col-sm-12 table-fixed">

                        <?php
                        $token  = "";
                        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                            if (isset($_POST['token'])) {
                                $token = $_POST['token'];
                                $_SESSION['token'] = $token;

                                $consulta_token = $dbDB->prepare("SELECT * FROM Visitante WHERE identificador = :identificador ORDER BY id ASC");
                                $consulta_token->bindParam(':identificador', $token);
                                $consulta_token->execute();
                                $id_consulta_token = $consulta_token->fetchAll(PDO::FETCH_ASSOC);
                            } else {
                                echo "Nenhum resultado encontrado.";
                            }
                        }
                        if (isset($id_consulta_token)) {
                            foreach ($id_consulta_token as $consulta) {
                        ?>
                                <thead class="">
                                    <tr class="thead-designer font-css font-css-dark p-0">
                                        <th class="th-designer">Nome</th>
                                        <th class="th-designer">Empresa </th>
                                        <th class="th-designer">Telefone</th>
                                        <th class="th-designer">Data da Visita</th>
                                        <th class="th-designer">Presença</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="listagem-back-blue mb-4">
                                        <td class="listagem-front-white font-css p-0">

                                            <span class="table-designer"><?= $consulta['nome']; ?></span>
                                            <span class="table-designer"><?= $consulta['empresa']; ?></span>
                                            <span class="table-designer"><?= $consulta['telefone']; ?></span>
                                            <span class="table-designer"><?= $consulta['periodo_visita_de']; ?></span>
                                            <span class="table-designer">
                                                <a href="../Controle-de-Visita-FullStack/Toten_Token/DB_Query_Portaria_Toten/portaria.php?id=<?= $consulta['id'] ?>" class="btn btn-info  font-id-css">
                                                    Confirmar
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                        <?php
                            }
                        } else {
                            // Caso não haja resultados para exibir
                            echo "Nenhum resultado encontrado";
                        }
                        ?>
                    </table>
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
<script src="../Controle-de-Visita-FullStack/Toten_Token/JS/main.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/index.js"></script>