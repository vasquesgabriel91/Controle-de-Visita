<?php 
session_start();
include_once('../../BD_Conncetion/connection.php'); 
// require_once('../../vendor/autoload.php');
//  $client = new \GuzzleHttp\Client();

$confirmacao = "";
$id_Visitante = "";
$token = "";


    if(isset($_GET['id'])){

        $id_Visitante = $_GET['id'];

        $pesquisar = $dbDB->prepare("SELECT COUNT(id_Visitante) AS count FROM Registro_da_Visita WHERE id_Visitante = :id_Visitante");
        $pesquisar->bindParam(':id_Visitante', $id_Visitante);
        $pesquisar->execute();
        $select = $pesquisar->fetch(PDO::FETCH_ASSOC)['count'];
        
        if($select > 0 ){
             $_SESSION['visita_confirmada'] = "Estamos a caminho para ajudá-lo, aguarde um momento";
             header("Location: ../../../Controle-de-Visita-FullStack/index.php");             
        }else{
            if(isset($_POST["token"])){
                $token = $_POST["token"];
                $verificarToken = $dbDB->prepare("SELECT COUNT(identificador) AS count  FROM Visitante WHERE identificador = :token");
                $verificarToken->bindParam(':token', $token);
                $verificarToken->execute();
                $tokeVerificado = $verificarToken->fetch(PDO::FETCH_ASSOC)['count'];
            }if($tokeVerificado == true){
                
                $confirmar = $dbDB->prepare("INSERT INTO Registro_da_Visita (id_Visitante) VALUES (:id_Visitante)");
                $confirmar->bindParam(':id_Visitante', $id_Visitante); 
                $id_confirmar = $confirmar->fetchAll(PDO::FETCH_ASSOC); 
                $_SESSION['MensagemPortaria'] = "Nossa equipe recebeu sua solicitação e já está indo ao seu encontro";
                 header("Location: ../../../Controle-de-Visita-FullStack/index.php");   

            } else{
                
                 $_SESSION['visita_confirmada'] = "Você está tentando confirmar uma visita que não é sua ou o token está incorreto";
                 header("Location: ../../../Controle-de-Visita-FullStack/index.php");   

            } if ($confirmar->execute()) { 

                $usuarios_com_acesso = $dbDB->prepare("SELECT * FROM usuarios INNER JOIN Cargos 
                ON usuarios.cargoid = Cargos.id WHERE Cargos.id IN (1, 2)");
                $usuarios_com_acesso->execute();
                $usuario = $usuarios_com_acesso->fetchAll(PDO::FETCH_ASSOC);
                if($usuario){

                    // foreach($usuario as $usuarios){

                    //     $nome = $usuarios['nome'];

                    //     $celular = $usuarios['celular'];

                    //     $mensagem = "Olá ".$nome.". A visita chegou e está aguardando na portaria.";

                    //     $response = $client->request('POST', 'https://v5.chatpro.com.br/chatpro-f3b90263e2/api/v1/send_message', [
                    //         'json' => 
                    //         [
                    //             'number' => $celular,
                    //             'message' => $mensagem,
                    //             'quoted_message_id' => '',
                    //         ],
                    //       'headers' => [
                    //         'Authorization' => '66f0dd9e9b0557244e2262c924eede54',
                    //         'accept' => 'application/json',
                    //         'content-type' => 'application/json',
                    //       ],
                    //     ]);
                    //     echo $response->getBody();
                    //   }

                    // header("Location: ../../../Controle-de-Visita-FullStack/index.php");    

            }else{
                echo "não foi possível mandar mensagem, tente novamente mais tarde";
            }  
        }
        }
       
   }else{
       echo "Nenhum resultado encontrado.";
   }

?>

