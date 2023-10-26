<?php

session_start();
include_once('../BD_Conncetion/connection.php'); 

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            header("location: ../View/login.php");
        exit;   
    }
    function inserirSolicitacao($dbDB, $nome, $celular, $email, $data_entrevista, $identificador) {

        $inserir = $dbDB->prepare("INSERT INTO solicitacao_entrevista (nome, celular, email, data_entrevista, identificador) VALUES (:nome, :celular, :email, :data_entrevista, :identificador)");
    
        $inserir->bindParam(':nome', $nome);
        $inserir->bindParam(':celular', $celular);
        $inserir->bindParam(':email', $email);
    
        // Certifique-se de que o formato da data seja válido (assumindo o formato YYYY-MM-DDTHH:MM)
        $data_entrevista = date('Y-m-d H:i:s', strtotime($data_entrevista));
        $inserir->bindParam(':data_entrevista', $data_entrevista);
        $inserir->bindParam(':identificador', $identificador);

        return $inserir->execute();
    }
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        for ($i = 0; $i < count($_POST['nome']); $i++) {
            $nome = $_POST['nome'][$i];
            $celular = $_POST['celular'][$i];
            $email = $_POST['email'][$i];
            $data_entrevista = $_POST['periodo_visita_de'][$i];
            
            // Chama a função para inserir os dados.
            inserirSolicitacao($dbDB, $nome, $celular, $email, $data_entrevista, $identificador);
        }
    }

    
?>