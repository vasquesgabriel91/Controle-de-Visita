<?php
include_once('../../BD_Conncetion/connection.php');
// require_once('../../vendor/autoload.php');
//  $client = new \GuzzleHttp\Client();

include_once('../../BD_Conncetion/connection.php');

$confirmacao = "";
$id_Visitante = "";
$token = "";
if (isset($_GET['id'])) {
    $id_Visitante = $_GET['id'];

    $pesquisar = $dbDB->prepare("SELECT COUNT(id_Visitante) AS count FROM Registro_da_Visita WHERE id_Visitante = :id_Visitante");
    $pesquisar->bindParam(':id_Visitante', $id_Visitante);
    $pesquisar->execute();
    $select = $pesquisar->fetch(PDO::FETCH_ASSOC)['count'];

    if ($select > 0) {
        $_SESSION['visita_confirmada'] = "Estamos a caminho para ajudá-lo, aguarde um momento";
        header("Location: ../../../Controle-de-Visita-FullStack/index.php");
    } else {
        if (isset($_POST['token']) && is_numeric($_POST['token'])) {
            $token =  $_POST['token'];
            
            $verificarToken = $dbDB->prepare("SELECT id, identificador FROM Visitante WHERE id = :id_Visitante AND identificador = :token");
            $verificarToken->bindParam(':id_Visitante', $id_Visitante);
            $verificarToken->bindParam(':token', $token);
            $verificarToken->execute();
            $visitante = $verificarToken->fetch(PDO::FETCH_ASSOC);

            if ($visitante) {
                // O token é válido and corresponde ao visitante, agora você pode inserir o registro
                $confirmar = $dbDB->prepare("INSERT INTO Registro_da_Visita (id_Visitante) VALUES (:id_Visitante)");
                $confirmar->bindParam(':id_Visitante', $id_Visitante);
                $confirmar->execute();
                
                $_SESSION['MensagemPortaria'] = "Nossa equipe recebeu sua solicitação e já está indo ao seu encontro";
                header("Location: ../../../Controle-de-Visita-FullStack/index.php");
            } else {
                $_SESSION['visita_confirmada'] = "Você está tentando confirmar uma visita que não é sua ou o token está incorreto";
                header("Location: ../../../Controle-de-Visita-FullStack/index.php");
            }
        } else {
            $_SESSION['visita_confirmada'] = "Você está tentando confirmar uma visita que não é sua ou o token está incorreto";
            header("Location: ../../../Controle-de-Visita-FullStack/index.php");
        }
    }
} else {
    echo "Nenhum resultado encontrado.";
}
