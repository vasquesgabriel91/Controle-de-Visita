<?php
include_once('../BD_Conncetion/connection.php');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../View/login.php");
    exit;
}

function inserirSolicitacao($dbDB, $nome, $celular, $email, $data_entrevista)
{
    $inserir = $dbDB->prepare("INSERT INTO solicitacao_entrevista (nome, celular, email, data_entrevista) VALUES (:nome, :celular, :email, :data_entrevista)");
    $inserir->bindParam(':nome', $nome);
    $inserir->bindParam(':celular', $celular);
    $inserir->bindParam(':email', $email);
    $data_entrevista = date('Y-m-d H:i:s', strtotime($data_entrevista));
    $inserir->bindParam(':data_entrevista', $data_entrevista);

    if ($inserir->execute()) {
        $id_usuario = $_SESSION["id"];
        $inserir_aprov = $dbDB->prepare("INSERT INTO aprovacao (id_usuario, aprovado_reprovado) VALUES (:id_usuario, 'on')");
        $inserir_aprov->bindParam(':id_usuario', $id_usuario);
        if ($inserir_aprov->execute()) {
            $_SESSION['sucesso'] = "Entrevista foi criada e aprovada com sucesso";
            header("Location: ../View/solicitacao_entrevista.php");
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    for ($i = 0; $i < count($_POST['nome']); $i++) {
        $nome = $_POST['nome'][$i];
        $celular = $_POST['celular'][$i];
        $email = $_POST['email'][$i];
        $data_entrevista = $_POST['periodo_visita_de'][$i];
        // Chame a função para inserir os dados.
        inserirSolicitacao($dbDB, $nome, $celular, $email, $data_entrevista);
    }
}
function readSolicitacaoEntrevista($dbDB)
{
    $read = $dbDB->prepare("SELECT * FROM solicitacao_entrevista ORDER BY id ASC");
    $read->execute();
    $query = $read->fetchAll(PDO::FETCH_ASSOC);

    return $query;
}

function paginacao($dbDB, $paginaAtual = 1, $limite = 5)
{
    $paginaAtual = 1;
    $limite = 5;

    if (isset($_GET['paginaAtual'])) {
        $paginaAtual = filter_input(INPUT_GET, "paginaAtual", FILTER_VALIDATE_INT);
    } else {
        $paginaAtual = 1;
    }

    if ($paginaAtual) {

        $inicio = ($paginaAtual * $limite) - $limite;

        $consulta = $dbDB->prepare("SELECT * FROM solicitacao_entrevista ORDER BY  id OFFSET $inicio ROWS FETCH NEXT $limite ROWS ONLY");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $registro = $dbDB->query("SELECT COUNT(id) as count FROM solicitacao_entrevista")->fetch()["count"];
        $_SESSION["paginas"] = $paginas = ceil($registro / $limite);
        return $resultado;
    }
}
