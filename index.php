
<?php
    session_start();
    require_once './BD_Conncetion/connection.php';
    require_once './Toten_Token/View/Side_Bar_Toten.php';
   
    $paginaAtual = 1;
    $limite = 5;
    
    if (isset($_GET['paginaAtual'])) { 
        $paginaAtual = filter_input(INPUT_GET, "paginaAtual", FILTER_VALIDATE_INT);
    } else {
        $paginaAtual = 1;
    }
    
    if ($paginaAtual) {
        $hoje = date('Y-m-d'); // Formato: Ano-Mês-Dia
    
        $inicio = ($paginaAtual * $limite) - $limite;
    
        $consulta_data = $dbDB->prepare("SELECT * FROM Visitante WHERE CONVERT(DATE, periodo_visita_de) = :hoje ORDER BY id OFFSET $inicio ROWS FETCH NEXT $limite ROWS ONLY");
        $consulta_data->bindParam(':hoje', $hoje);
        $consulta_data->execute();
        $resultado_data = $consulta_data->fetchAll(PDO::FETCH_ASSOC);
    
        $consulta_count_data = $dbDB->prepare("SELECT COUNT(*) as count FROM Visitante WHERE CONVERT(DATE, periodo_visita_de) = :hoje");
        $consulta_count_data->bindParam(':hoje', $hoje);
        $consulta_count_data->execute();
        $totalRegistros = $consulta_count_data->fetchColumn();
        $paginas = ceil($totalRegistros / $limite);
    }
    
    // FAZ A PESQUISA NA TABELA 
    // if (isset($_GET['token_ou_name']) && !empty($_GET['token_ou_name'])) {
    //     $token_ou_name = '%' . strtolower($_GET['token_ou_name']) . '%'; // Converter para minúsculas
    //     $consulta = $dbDB->prepare("SELECT * FROM Visitante WHERE nome LIKE '%$token_ou_name%' or identificador LIKE '%$token_ou_name%' ORDER BY id DESC");
    //     $consulta->execute([$token_ou_name]);
    // } else {
    //     $consulta = $dbDB->prepare("SELECT * FROM Visitante ORDER BY id OFFSET $inicio ROWS FETCH NEXT $limite ROWS ONLY");
    //     $consulta->execute();
    //     $resultado_data = $consulta->fetchAll(PDO::FETCH_ASSOC);
    // }
    


 ?>


<body class=" d-flex flex-row">
    <div class=" d-flex flex-column col"> 
        
        <div class="d-flex justify-content-center mt-5 mb-5">
            <div class="d-flex justify-content-start text-dark col-sm-10 justify-content-between align-items-center ">
                <span class="titulo">
                    Consultar Visita: <?= date('d/m/Y'); ?>
                </span>
                <span>
                    <a href="../Controle-de-Visita-FullStack/View/home.php" id="btn-primary" class=" text-decoration-none btn btn-primary font-css" role="button">Painél Administrativo</a>
                </span>
            </div>
        </div> 

        <div class="d-flex flex-column align-items-center mt-5">
            <span class="titulo"> Procure seu agendamento</span>
            <form action="" method="GET" class="col-sm-8 mt-5">
                <div class="d-flex align-items-center justify-content-between rounded-pill col-sm-12 bg-light border-radius-css">
                    <input type="text" autocomplete="off"  placeholder="Digite seu Token ou Nome completo" id="pesquisar" name="token_ou_name" class="input rounded-pill border-0 p-1 me-2 bg-light col-sm-10 focus-outline-none-css" >
                    <button type="submit" class="border-0 bg-transparent d-flex flex-row align-items-center justify-content-end col-sm-1 me-3 rounded-pill">
                        <i class="fa-solid fa-magnifying-glass me-3" style="color: #00b0f2;"> </i>
                        <span class="font-css">PESQUISAR</span>
                    </button>
                </div>
                <div class="simple-keyboard "></div>
            </form>
        </div>
        
        <div class="col-sm-12  d-flex justify-content-center mt-5">
            <div class="d-flex flex-column col-sm-12 d-flex justify-content-center align-items-center">
                <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12">

                    <table class="d-flex align-items-center table-css flex-column col-sm-12">
                        <thead class="col-sm-11">
                            <tr class="d-flex flex-row justify-content-around align-items-center mb-4 font-css font-css-dark">
                                <th>Nome</th>
                                <th>Empresa</th>
                                <th>Telefone</th>
                                <th>Area da Visita</th>
                                <th>Data de Visita</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($resultado_data as $resultados): ?>
                                
                                <tr class="listagem-back-blue mb-4">
                                    <td class="listagem-front-white font-css " data-bs-toggle="modal" data-bs-target="#exampleModal<?= $resultados['id']; ?>">
                                        <div class="d-flex justify-content-between font-css col-sm-12 ps-3 pe-5">
                                            <span><?= $resultados['nome']; ?></span>
                                            <span><?= $resultados['empresa']; ?></span>
                                            <span><?= $resultados['telefone']; ?></span>
                                            <span><?= $resultados['area_da_visita']; ?></span>
                                            <span><?= date('d/m/Y - H:i', strtotime($resultados['periodo_visita_de'])); ?></span>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?= $resultados['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-css p-3 shadow " id="modal-warning">
                                        <div class="d-flex flex-row justify-content-end col-sm-12 ">
                                                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-content modal-content-css border-0 ">
                                                <div class="modal-body modal-body-css ">
                                                    <span class="titulo"> Digite seu Token de confirmação</span>
                                                    <form action=" ../Controle-de-Visita-FullStack/Toten_Token/DB_Query_Portaria_Toten/portaria.php?id=<?= $resultados['id']?>" method="POST" class="col-sm-11 mt-5">
                                                        <div class="d-flex align-items-center justify-content-between rounded-pill col-sm-12 border-radius-css">
                                                            <input type="text" autocomplete="off"  placeholder="Digite seu Token" id="pesquisar" name="token" class="input rounded-pill border-0 p-1 me-2 bg-light col-sm-10 focus-outline-none-css" >
                                                            <button type="submit" class="border-0 bg-transparent d-flex flex-row align-items-center justify-content-end col-sm-1 me-3 rounded-pill">
                                                                <i class="fa-solid fa-magnifying-glass me-3" style="color: #00b0f2;"> </i>
                                                                <span class="font-css">PESQUISAR</span>
                                                            </button>
                                                        </div>
                                                        <div class="simple-keyboard "></div>
                                                    </form>
                                                <div class="d-flex justify-content-end mt-4 col-sm-11">
                                                    <button type="button" class="btn btn-danger col-sm-3" data-bs-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                    
                    <div class="d-flex col-sm-12 justify-content-center align-items-center mb-4 ">
                        <div class="d-flex flex-row justify-content-end col-sm-9 align-items-center">
                            <a href="?paginaAtual=1" class="me-2 text-decoration-none  color-paginacao">Primeira</a>
                            <?php if($paginaAtual>1):?>
                                <a href="?paginaAtual=<?=$paginaAtual-1 ?>" class="d-flex justify-content-center align-items-center"> 
                            <?php endif;?>       
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                        <path d="M10 1L2 5.76191L10 11" stroke="#004159" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            <div class="d-flex align-items-center justify-content-center circle-css">
                                <span><?= $paginaAtual ?></span>
                            </div>
                            <?php if($paginaAtual<$paginas):?>
                                <a href="?paginaAtual=<?=$paginaAtual+1 ?>" class="d-flex justify-content-center align-items-center"> 
                            <?php endif;?>
                            
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                        <path d="M1 11L9 6.23809L1 1" stroke="#004159" stroke-width="2" stroke-linecap="round"/>
                                    </svg>

                                </a>
                            <a href="?paginaAtual=<?=$paginas?>" class="ms-2 text-decoration-none color-paginacao">Ultima</a>
                        </div>
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
    <script src="./Toten_Token/JS/main.js"></script>


     