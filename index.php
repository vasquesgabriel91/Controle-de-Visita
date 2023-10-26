
<?php
    session_start();
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
        
        <div class="d-flex justify-content-center mt-5 mb-5">
            <div class="d-flex justify-content-start text-dark col-sm-10 justify-content-between align-items-center ">
                <span class="titulo">
                    Consultar Visita: <?= date('d/m/Y')?>
                </span>
                <span>
                    <a href="../Controle-de-Visita-FullStack/View/home.php" id="btn-primary" class=" text-decoration-none btn btn-primary font-css" role="button">Painel administrativo</a>
                </span>
            </div>
        </div> 

        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data</th>
                    <th>Telefone</th>
                    <th>area da visita</th>
                    <th>Periodo de visita</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado_data as $resultados){ ?>
                    <tr>
                        <td><?= $resultados['nome']; ?></td>
                        <td><?= $resultados['empresa']; ?></td>
                        <td><?= $resultados['telefone']; ?></td>
                        <td><?= $resultados['area_da_visita']; ?></td>
                        <td><?= date('d/m/Y - H:i', strtotime($resultados['periodo_visita_de'])); ?></td>
                    </tr>
                <?php }?>
            </tbody>
        </table>        
                        
               

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