
<?php
session_start();
include_once('../BD_Conncetion/connection.php'); 


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $celular = $_POST["celular"];
    $email = $_POST["email"];
    $periodo_visita_de = date('Y-m-d H:i', strtotime($_POST["periodo_visita_de"]));
    $periodo_visita_ate = date('Y-m-d H:i', strtotime($_POST["periodo_visita_ate"]));
    $empresa = $_POST["empresa"];
    $visitante = $_POST["visitante"];
    $area_da_visita = $_POST["area_da_visita"];
    $acesso_fabrica = isset($_POST["acesso_fabrica"]) ? true : false;
    $acesso_estacionamento = isset($_POST["acesso_estacionamento"]) ? true : false;
    $observacao = $_POST["observacao"];
    $motivo_visita = $_POST["motivo_visita"];
    $identificador = rand(1,1000);

    $inserir = $dbDB->prepare("INSERT INTO Visitante (
        nome,
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
        observacao,
        motivo_visita,
        identificador
        ) VALUES (
            :nome,
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
            :observacao,
            :motivo_visita,
            :identificador)"
            );
            $inserir->bindParam(':nome', $nome);    
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
            $inserir->bindParam(':observacao', $observacao);
            $inserir->bindParam(':motivo_visita', $motivo_visita);
            $inserir->bindParam(':identificador',$identificador);
            if($inserir->execute()){
                
                $_SESSION['sucesso'] = "Visita foi criada com sucesso";
                header("Location: ../View/solicitacao.php"); 
           
                $id = $dbDB->lastInsertId();
                $consulta = $dbDB->prepare("SELECT acesso_fabrica FROM Visitante WHERE id = :visitante_id");
                $consulta->bindParam(':visitante_id', $id);
                $consulta->execute();
                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if ($resultado && $resultado['acesso_fabrica'] == 0) {
                        $id_usuario = $_SESSION["id"];
                        $id = $dbDB->lastInsertId();
                        $insertInto = $dbDB->prepare("INSERT INTO aprovacao (id_visitante, id_usuario, aprovado_reprovado) VALUES (:resultados, :id_usuario, 'on' )");
                        $insertInto->bindParam(':id_usuario', $id_usuario);
                        $insertInto->bindParam(':resultados', $id);
                        $insertInto->execute();

                        $_SESSION['sucesso'] = "Visita foi criada e aprovada com sucesso";
                        header("Location: ../View/solicitacao.php"); 
                    }else{
                     echo "Erro para aprovação";
                    }

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
    
                 
                
            }
}




?>
