<?php
    session_start();
    include_once('../BD_Conncetion/connection.php'); 
    
    // Verifica se o usuário já está logado
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: ../View/home.php");
        exit;
    }
    
    // Validação para logar o usuarios
    $email = "";
    $senha = "";
    $senhaErro = "";
    $emailErro = "";
    $usuarioExiste = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (empty(trim($_POST["email"]))){
            $emailErro = "Por favor, coloque um email válido";
        } else {
            $email = trim($_POST["email"]);}

        if (empty(trim($_POST["senha"]))) {  
            $senhaErro = "Por favor, insira uma senha";
        }else{
            $senha = trim($_POST["senha"]);
        }

        if (empty($emailErro) && empty($senhaErro)){
            // Verifica se o email já existe no banco de dados
            $verificarUser = $dbDB->prepare("SELECT * FROM usuarios WHERE email = :email");
            $verificarUser->bindParam(':email', $email);
            $verificarUser->execute(); 
            $resultado = $verificarUser->fetch(PDO::FETCH_ASSOC);
    
            if($resultado){
                $email_login = $resultado['email'];
                $senha_hash_login = $resultado['senha'];
                if(password_verify($senha, $senha_hash_login)){
                    
                    session_start();
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $resultado['id']; 
                    $_SESSION["email"] = $email;     
                    $_SESSION["cargoid"] = $resultado['cargoid'];//SERÁ ENVIADA PARA SIDE_BAR_HOMECONTROLLER
                    $_SESSION["celular"] = $resultado['celular']; 
                    $_SESSION["nome"] = $resultado['nome']; 
    
                    header("location: home.php");
                    exit;
                }else{
                    $usuarioExiste = "Senha inválida";
                }
            }else{
                $usuarioExiste = "Email inválido";
            }
                  
        }
      
    }

    ?>