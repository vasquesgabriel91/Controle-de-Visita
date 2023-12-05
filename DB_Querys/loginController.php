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


    $emailErro = "";
    $email = ($_POST["email"]);

    $senhaErro = "";
    $senha = ($_POST["senha"]);

    login($dbDB, $email, $senha);
}

function login($dbDB, $email, $senha){
    global $senhaErro, $emailErro, $email_login, $usuarioExiste;
    if (empty(trim($email))) {
        $emailErro = "Por favor, coloque um email válido";
    }

    if (empty(trim($senha))) {
        $senhaErro = "Por favor, insira uma senha";
    }

    if (!empty($email) && !empty($senha)) {
        // Verifica se o email já existe no banco de dados
        $verificarUser = $dbDB->prepare("SELECT * FROM usuarios WHERE email = :email");
        $verificarUser->bindParam(':email', $email);
        $verificarUser->execute();
        $resultado = $verificarUser->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $email_login = $resultado['email'];
            $senha_hash_login = $resultado['senha'];
            if (password_verify($senha, $senha_hash_login)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $resultado['id'];
                $_SESSION["email"] = $email;
                $_SESSION["cargoid"] = $resultado['cargoid'];
                $_SESSION["celular"] = $resultado['celular'];
                $_SESSION["nome"] = $resultado['nome'];
                header("location: home.php");
            } else {
                $usuarioExiste = "Senha inválida";
            }
        } else {
            $usuarioExiste = "Email inválido";
        }
    }
}
?>