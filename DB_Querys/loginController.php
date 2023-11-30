<?php
include_once('../BD_Conncetion/connection.php');

// Verifica se o usuário já está logado
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../View/home.php");
    exit;
}

// Validação para logar o usuarios
$email = "";
$senha = "";
$senhaErro = "";
$emailErro = "";
$usuarioExiste = "";
$email_login = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $emailErro = "Por favor, coloque um email válido";
    $email = ($_POST["email"]);

    $senhaErro = "Por favor, insira uma senha";
    $senha = ($_POST["senha"]);

    login($dbDB, $emailErro, $email, $senhaErro, $senha);
}

function login($dbDB, $emailErro, $email, $senhaErro, $senha) {
    if (empty(trim($email))) {
        $emailErro = "Por favor, coloque um email válido";
    }

    if (empty(trim($senha))) {
        $senhaErro = "Por favor, insira uma senha";
    }

    if (empty($emailErro) && empty($senhaErro)) {
        // Verifica se o email já existe no banco de dados
        $verificarUser = $dbDB->prepare("SELECT * FROM usuarios WHERE email = :email");
        $verificarUser->bindParam(':email', $email);
        $verificarUser->execute();
        $resultado = $verificarUser->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $email_login = $resultado['email'];
            $senha_hash_login = $resultado['senha'];
            if (password_verify($senha, $senha_hash_login)) {
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $resultado['id'];
                $_SESSION["email"] = $email;
                $_SESSION["cargoid"] = $resultado['cargoid'];
                $_SESSION["celular"] = $resultado['celular'];
                $_SESSION["nome"] = $resultado['nome'];
                header("location: home.php");
                exit;
            } else {
                $usuarioExiste = "Senha inválida";
            }
        } else {
            $usuarioExiste = "Email inválido";
        }
    }
}