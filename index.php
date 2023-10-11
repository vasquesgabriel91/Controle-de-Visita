
<?php
    session_start();
    require_once './BD_Conncetion/connection.php';
    require_once './Toten_Token/View/Side_Bar_Toten.php';
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
                            <input type="text" autocomplete="off"  placeholder="Pesquisar" id="pesquisar" name="token" class="input rounded-pill border-0 p-1 me-2 bg-light col-sm-10 focus-outline-none-css" >
                            <button type="submit" class="border-0 bg-transparent d-flex flex-row align-items-center justify-content-end col-sm-1 me-3 rounded-pill">
                                <i class="fa-solid fa-magnifying-glass me-3" style="color: #00b0f2;"> </i>
                                <span class="font-css">PESQUISAR</span>
                            </button>
                        </div>
                        <div class="simple-keyboard "></div>

                    </form>

                <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12 ">
                    <table class=" col d-flex table-css">
                            <?php 
                            $token  = "";
                            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                if(isset($_POST['token'])){
                                    $token = $_POST['token'];
                                    $consulta_token = $dbDB->prepare("SELECT * FROM Visitante WHERE identificador = :identificador ORDER BY id ASC");
                                    $consulta_token->bindParam(':identificador', $token); 
                                    $consulta_token->execute();
                                    $id_consulta_token = $consulta_token->fetchAll(PDO::FETCH_ASSOC);   
                                    
                                }else{
                                    echo "Nenhum resultado encontrado.";
                                }
                            }
                                if (isset($id_consulta_token)) {
                                    foreach ($id_consulta_token as $consulta) {
                                        ?>
                                        <tr class="d-flex flex-row justify-content-around align-items-center mb-4 font-css font-css-dark col-sm-12 ">
                                            <th>Nome</th>
                                            <th>Empresa </th>
                                            <th>Telefone</th>
                                            <th>Data da Visita</th>
                                        <tr class="mb-4 listagem-back-blue ">
                                            <td class="listagem-front-white flex-column ">
                                                <div class="d-flex justify-content-between font-css col-sm-12 ps-3 pe-5">
                                                    <span><?= $consulta['nome']; ?></span>
                                                    <span><?= $consulta['empresa']; ?></span>
                                                    <span><?= $consulta['telefone']; ?></span>                                            
                                                    <span><?= $consulta['periodo_visita_de']; ?></span>
                                                </div>   
                                                <div class="col-sm-10 presenca font-css col-sm-12 ">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <label for="">Confirmar presença</label>
                                                        <div class="btn btn-info border-0" id="bg-btn">
                                                            <a href="../Controle-de-Visita-FullStack/Toten_Token/DB_Query_Portaria_Toten/portaria.php?id=<?= $consulta['id']?>" class="text-decoration-none text-white">
                                                                Confirmar
                                                            </a>    
                                                        </div>
                                                    </div>
                                                </div>                     
                                            </td>    
                                        </tr>
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

    <script src="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/index.js"></script>
    <script src="./Toten_Token/JS/main.js"></script>
</body>
 

    <?php
        if (isset($_SESSION['visita_confirmada'])) {
        ?>
        <div class="alert position-absolute flash-message">

            <div class="flash-message-child p-4">
                <i class="fa-solid fa-circle-exclamation fa-shake " style="color: #fb1313; font-size: 5rem;"></i>

                <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                    <p class="font-flash-message">
                        Já confirmamos sua visita.
                    </p>
                    <span class="font-css">
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