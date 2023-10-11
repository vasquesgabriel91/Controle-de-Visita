
<?php
session_start();
include_once('../BD_Conncetion/connection.php'); 


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $rg = $_POST["rg"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $celular = $_POST["celular"];
    $email = $_POST["email"];
    $periodo_visita_de = date('Y-m-d H:i:s', strtotime($_POST["periodo_visita_de"]));
    $periodo_visita_ate = date('Y-m-d H:i:s', strtotime($_POST["periodo_visita_ate"]));
    $empresa = $_POST["empresa"];
    $visitante = $_POST["visitante"];
    $area_da_visita = $_POST["area_da_visita"];
    $acesso_fabrica = isset($_POST["acesso_fabrica"]) ? true : false;
    $acesso_estacionamento = isset($_POST["acesso_estacionamento"]) ? true : false;
    $placa_carro = $_POST["placa_carro"];
    $modelo_carro = $_POST["modelo_carro"];
    $observacao = $_POST["observacao"];
    $identificador = rand(1,1000);

    $inserir = $dbDB->prepare("INSERT INTO Visitante (
        nome,
        rg,
        cpf,
        telefone,
        celular,
        email,
        periodo_visita_de,
        periodo_visita_ate,
        empresa,
        visitante,
        area_da_visita,
        acesso_fabrica,
        acesso_estacionamento,
        placa_carro,
        modelo_carro,
        observacao,
        identificador
        ) VALUES (
            :nome,
            :rg,
            :cpf,
            :telefone,
            :celular,
            :email,
            :periodo_visita_de,
            :periodo_visita_ate,
            :empresa,
            :visitante,
            :area_da_visita,
            :acesso_fabrica,
            :acesso_estacionamento,
            :placa_carro,
            :modelo_carro,
            :observacao,
            :identificador)"
            );
            $inserir->bindParam(':nome', $nome);
            $inserir->bindParam(':rg', $rg);
            $inserir->bindParam(':cpf', $cpf);
            $inserir->bindParam(':telefone',  $telefone);
            $inserir->bindParam(':celular', $celular);
            $inserir->bindParam(':email', $email);
            $inserir->bindParam(':periodo_visita_de', $periodo_visita_de);
            $inserir->bindParam(':periodo_visita_ate', $periodo_visita_ate);
            $inserir->bindParam(':empresa', $empresa);
            $inserir->bindParam(':visitante', $visitante);
            $inserir->bindParam(':area_da_visita', $area_da_visita);
            $inserir->bindParam(':acesso_fabrica', $acesso_fabrica );
            $inserir->bindParam(':acesso_estacionamento', $acesso_estacionamento);
            $inserir->bindParam(':placa_carro', $placa_carro);
            $inserir->bindParam(':modelo_carro', $modelo_carro);
            $inserir->bindParam(':observacao', $observacao);
            $inserir->bindParam(':identificador',$identificador);

            if($inserir->execute()){
                // Consulta para obter o número de celular do último usuário
                
                //     $ultimoID = $dbDB->lastInsertId();
                //     $consulta = $dbDB->prepare ("SELECT * FROM Visitante WHERE id = :ultimoID");
                //     $consulta->bindParam(':ultimoID', $ultimoID, PDO::PARAM_INT);
                //     $consulta->execute();
                //     // Recuperar o número de celular do último usuário cadastrado
                //     $dadosUsuario = $consulta->fetch(PDO::FETCH_ASSOC);
                
                //      $data = $dadosUsuario['periodo_visita_de'];
                //      $nome_Empresa = $dadosUsuario['empresa'];
                
                //      $celular_Auth = $_SESSION["celular"];
                //      $nome_Auth = $_SESSION["nome"];
                
                //      $mensage = 'Olá, '.$nome_Auth.' Informo que a empresa ' .$nome_Empresa. ' visitará a Paranoá no dia '.$data.'';
    
                    $_SESSION['sucesso'] = "Visita foi criada com sucesso";
                    header("Location: ../View/solicitacao.php"); 
                
                }
}




?>
