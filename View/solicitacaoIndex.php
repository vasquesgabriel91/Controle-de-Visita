<?php 
    require_once 'Side_Bar_home.php';   
    require_once '../DB_Querys/home_Paginacao_Tabela.php'; 
    require_once '../DB_Querys/solicitacaoUpdate.php'; 


    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: ../View/login.php");
        exit;   
    }
?>


<div class="col d-flex justify-content-center">
    <div class="d-flex flex-column col align-items-center">
        <div class="d-flex bg-transparent border-0 mt-5 mb-5 col-sm-10">
            <h2 class="text-title-css">
                Solicitação de Visita
            </h2>
        </div>
        <div class="bg-form-css d-flex  col-sm-10 mb-5  ">
            <form action="../DB_Querys/solicitacaoUpdate.php" method="post" class=" col-sm-12 d-flex flex-column pt-4 ">
                <div class="d-flex flex-row justify-content-around">
                    <div class="d-flex flex-column col-sm-5 ">
                        <?php if(isset($resultadoRead)) {?>
                            <input type="hidden" id="id" class="input-css" name="id" value="<?= $resultadoRead['id']; ?>" >

                            <label class="label-css" for="nome">Nome:</label>
                            <input type="text" id="nome" class="input-css" name="nome" value="<?= $resultadoRead['nome']; ?>" >

                            <label  class="label-css" for="rg">RG:</label>
                            <input type="text" id="rg" class="input-css" name="rg" value="<?= $resultadoRead['rg']; ?>">

                            <label  class="label-css" for="cpf">CPF:</label>
                            <input type="text" id="cpf" class="input-css"name="cpf" value="<?= $resultadoRead['cpf']; ?>">

                            <label  class="label-css" for="telefone">Telefone:</label>
                            <input type="text" id="telefone" class="input-css" name="telefone" value="<?= $resultadoRead['telefone']; ?>">

                            <label  class="label-css" for="celular">Celular:</label>
                            <input type="text" id="celular" class="input-css" name="celular" value="<?= $resultadoRead['celular']; ?>">

                            <label  class="label-css" for="email">Email:</label>
                            <input type="email" id="email" class="input-css" name="email" value="<?= $resultadoRead['email']; ?>">

                            <label  class="label-css" for="periodo_visita_de">Período de Visita (de):</label>
                            <input type="datetime-local" id="periodo_visita_de" class="input-css" name="periodo_visita_de" value="<?=date('Y-m-d H:i:s', strtotime($periodo_visita_de));?>">

                            <label  class="label-css" for="periodo_visita_ate">Período de Visita (até):</label>
                            <input type="datetime-local" id="periodo_visita_ate" class="input-css" name="periodo_visita_ate" value="<?= $periodo_visita_ate; ?>">
                    </div>

                    <div class="d-flex flex-column col-sm-5">
                        <label  class="label-css" for="empresa">Empresa:</label>
                        <input type="text" id="empresa" class="input-css" name="empresa" value="<?= $resultadoRead['empresa']; ?>">

                        <label  class="label-css" for="visitante">Visitante:</label>
                        <input type="text" id="visitante" class="input-css" name="visitante"  value="<?= $resultadoRead['visitante']; ?>">

                        <label  class="label-css" for="area_da_visita">Área da Visita:</label>
                        <input type="text" id="area_da_visita" class="input-css" name="area_da_visita"  value="<?= $resultadoRead['area_da_visita']; ?>">

                        <label  class="label-css" for="placa_carro">Placa do Carro:</label>
                        <input type="text" id="placa_carro" class="input-css" name="placa_carro" value="<?= $resultadoRead['placa_carro']; ?>">

                        <label  class="label-css" for="modelo_carro">Modelo do Carro:</label>
                        <input type="text" id="modelo_carro" class="input-css" name="modelo_carro" value="<?= $resultadoRead['modelo_carro']; ?>">
                            
                        <input type="hidden" id="identificador" class="input-css" name="identificador">

                        <label for="observacao"class="label-css">Observação:</label>
                        <textarea id="observacao" class="input-textarea-css mb-1" name="observacao"><?= $resultadoRead['observacao']; ?></textarea>
                            
                        <div class="d-flex flex-column justify-content-around acesso-css">
                            <div class="d-flex align-items-center">
                                <label class="pe-2 label-acesso-css" for="acesso_fabrica">Acesso à Fábrica:</label>
                                <input type="checkbox" id="acesso_fabrica" class="inputBox-css" name="acesso_fabrica" <?= $resultadoRead['acesso_fabrica'] ? 'checked' : ''; ?>>
                            </div>

                            <div class="d-flex align-items-center">
                                <label class="pe-2 label-acesso-css" for="acesso_estacionamento">Acesso ao Estacionamento:</label>
                                <input type="checkbox" id="acesso_estacionamento" class="inputBox-css" name="acesso_estacionamento" <?= $resultadoRead['acesso_estacionamento'] ? 'checked' : ''; ?>>
                            </div>
                        </div>
                    </div>
                        <?php } ?>
                </div>  
                <div class="d-flex justify-content-center mt-4 mb-4">
                    <input type="submit" value="Editar" class="btn-submit-css mt-3 ">
                </div>
            </form>
        </div>
    </div>
</div>
       

 