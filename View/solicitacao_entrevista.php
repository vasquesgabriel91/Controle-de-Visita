<?php 
    require_once 'Side_Bar_home.php';
    include_once('../BD_Conncetion/connection.php'); 
    require_once('../DB_Querys/solicitacao_entrevista.php');
    $dados = readSolicitacaoEntrevista($dbDB);

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: ../View/login.php");
        exit;   
    }
?>

<div class="col d-flex justify-content-center">
    <div class="d-flex flex-column col align-items-center ">
        <div class="d-flex bg-transparent border-0 mt-5 mb-5 col-sm-10">
            <h2 class="text-title-css">
                Solicitação de Entrevista
            </h2>
        </div>
        <div class=" d-flex col-sm-10 mb-5 bg-form-css align-items-center justify-content-around p-3">
            <div class="col-sm-10 d-flex justify-content-around">
                <div class="d-flex flex-column col-sm-5">
                    <label class="label-css" for="nome">Nome:</label>
                    <input type="text" id="nome" class="input-css" placeholder="Nome" require  >

                    <label class="label-css" for="celular">Celular:</label>
                    <input type="text" id="celular" class="input-css" placeholder="Celular">
                </div>
                <div class="d-flex flex-column col-sm-5">
                    <label class="label-css" for="email">Email:</label>
                    <input type="email" id="email" class="input-css" placeholder="Email">

                    <label class="label-css" for="periodo_visita_de">Data da entrevista:</label>
                    <input type="datetime-local" id="periodo_visita_de" class="input-css" >
                </div>
            </div>

            <div class="btn btn-success d-flex align-items-center" id="btnAdd">
                <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
            </div>
        </div>

        <div class="bg-form-css d-flex col-sm-10 ">
            <form  action="../DB_Querys/solicitacao_entrevista.php" method="post" class=" d-flex col-sm-12 justify-content-between ">
                    <div class="d-flex flex-row justify-content-around p-3 col-sm-12"  >
                        <div class="d-flex flex-column col-sm-4" id="myForm"></div>

                        <div class="d-flex flex-column col-sm-4" id="myForm2"></div>

                        <div class=" d-flex align-items-center justify-content-around flex-column " id="remove-btn"></div>

                        <div class=" d-flex flex-row align-items-end justify-content-end col-sm-1" >
                            <input class="btn btn-success  col-sm-12" type="submit" value="Enviar" id="btn-enviar" disabled >
                        </div>
                            
                    </div>
            </form>
        </div>
        <div class="d-inline-flex gap-1 mt-5">
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Button with data-bs-target
            </button>
        </div>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <!-- Adicione outras colunas da tabela aqui -->
                </tr>
                <?php foreach ($dados as $registro) { ?>
                <tr>
                    <td><?php echo $registro['id']; ?></td>
                    <td><?php echo $registro['nome']; ?></td>
                    <td><?php echo $registro['email']; ?></td>
                    <!-- Adicione outras colunas da tabela aqui -->
                </tr>
                <?php } ?>
            </table>
            </div>
        </div>
    </div>
    
    <script src="../Js/main.js" crossorigin="anonymous"></script>

</div>

