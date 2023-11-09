<?php

include_once('../BD_Conncetion/connection.php');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../View/login.php");
    exit;
}

////////// READ SOLICITACAOINDEX.PHP ///////////////
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $read = $dbDB->prepare("SELECT * FROM Visitante WHERE id = :id");
    $read->bindValue(':id', $id, PDO::PARAM_INT);
    $read->execute();
    $resultadoRead = $read->fetch(PDO::FETCH_ASSOC);

    // Formatar a data de início da visita
    $periodo_visita_de = date("Y-m-d H:i", strtotime($resultadoRead['periodo_visita_de']));

    // Formatar a data de término da visita
    $periodo_visita_ate = date("Y-m-d H:i", strtotime($resultadoRead['periodo_visita_ate']));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtenha os dados do formulário POST
    $id = $_POST['id'];
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $celular = $_POST["celular"];
    $email = $_POST["email"];
    $periodo_visita_de = date('Y-m-d H:i', strtotime($_POST["periodo_visita_de"]));
    $periodo_visita_ate = date('Y-m-d H:i', strtotime($_POST["periodo_visita_ate"]));
    $empresa = $_POST["empresa"];
    $visitante = $_POST["visitante"];
    $area_da_visita = $_POST["area_da_visita"];
    $acesso_fabrica = isset($_POST["acesso_fabrica"]) ? 1 : 0;
    $acesso_estacionamento = isset($_POST["acesso_estacionamento"]) ? 1 : 0;
    $observacao = $_POST["observacao"];
    $motivo_visita = $_POST["motivo_visita"];

    // Faça a atualização dos dados usando a função updateVisita
    $updateSuccess = updateVisita($dbDB, $id, $nome, $telefone, $celular, $email, $periodo_visita_de, $periodo_visita_ate, $empresa, $visitante, $area_da_visita, $acesso_fabrica, $acesso_estacionamento, $observacao, $motivo_visita);

    // Verifique se a atualização foi bem-sucedida
    if ($updateSuccess) {
        // Processar a aprovação, se necessário
        processarAprovacao($dbDB, $id, $acesso_fabrica);
    } else {
        echo "Erro";
    }
}

function updateVisita(
    $dbDB,
    $id,
    $nome,
    $telefone,
    $celular,
    $email,
    $periodo_visita_de,
    $periodo_visita_ate,
    $empresa,
    $visitante,
    $area_da_visita,
    $acesso_fabrica,
    $acesso_estacionamento,
    $observacao,
    $motivo_visita
) {

    $update = $dbDB->prepare("UPDATE Visitante SET 
        nome = :nome,
        telefone = :telefone,
        celular = :celular,
        email = :email,
        periodo_visita_de = :periodo_visita_de,
        periodo_visita_ate = :periodo_visita_ate,
        empresa = :empresa,
        visitante = :visitante,
        area_da_visita = :area_da_visita,
        acesso_fabrica = :acesso_fabrica,
        acesso_estacionamento = :acesso_estacionamento,
        observacao = :observacao,
        motivo_visita = :motivo_visita
        WHERE id = :id");

    $update->bindValue(':id', $id, PDO::PARAM_INT);
    $update->bindValue(':nome', $nome, PDO::PARAM_STR);
    $update->bindValue(':telefone', $telefone, PDO::PARAM_STR);
    $update->bindValue(':celular', $celular, PDO::PARAM_STR);
    $update->bindValue(':email', $email, PDO::PARAM_STR);
    $update->bindValue(':periodo_visita_de', $periodo_visita_de, PDO::PARAM_STR);
    $update->bindValue(':periodo_visita_ate', $periodo_visita_ate, PDO::PARAM_STR);
    $update->bindValue(':empresa', $empresa, PDO::PARAM_STR);
    $update->bindValue(':visitante', $visitante, PDO::PARAM_STR);
    $update->bindValue(':area_da_visita', $area_da_visita, PDO::PARAM_STR);
    $update->bindValue(':acesso_fabrica', $acesso_fabrica, PDO::PARAM_INT);
    $update->bindValue(':acesso_estacionamento', $acesso_estacionamento, PDO::PARAM_INT);
    $update->bindValue(':observacao', $observacao, PDO::PARAM_STR);
    $update->bindValue(':motivo_visita', $motivo_visita, PDO::PARAM_STR);
    if ($update->execute()) {
        return true;
    } else {
        return false;
    }
}

function processarAprovacao($dbDB, $id, $acesso_fabrica)
{
    $query = $dbDB->prepare("SELECT COUNT(id) FROM aprovacao WHERE id_visitante = :id_visitante");
    $query->bindValue(':id_visitante', $id, PDO::PARAM_INT);
    $query->execute();
    $resultado = $query->fetchColumn();

    if ($acesso_fabrica == 0) {
        if ($resultado <= 0) {
            $id_usuario = $_SESSION["id"];
            $insertInto = $dbDB->prepare("INSERT INTO aprovacao (id_visitante, id_usuario, aprovado_reprovado) VALUES (:resultados, :id_usuario, 'on' )");
            $insertInto->bindParam(':id_usuario', $id_usuario);
            $insertInto->bindParam(':resultados', $id);
            $insertInto->execute();
            $_SESSION['atualizado_sucesso'] = "Visita foi atualizada e aprovada com sucesso";
            header("Location: ../View/home.php");
        } else {
            //Deleta o formulario da tabela aprovação assim que edita o mesmo 
            $atualizando = $dbDB->prepare("DELETE FROM aprovacao WHERE id_visitante = :id_visitante");
            $atualizando->bindValue(':id_visitante', $id, PDO::PARAM_INT);
            if ($atualizando->execute()) {
                $_SESSION['atualizado_sucesso'] = "Visitantes que foram editados, precisam ser aprovados novamente.";
                header("Location: ../View/home.php");
            } else {
                echo "Erro ao excluir o registro.";
            }
        }
    } elseif ($resultado > 0) {
        //Deleta o formulario da tabela aprovação assim que edita o mesmo 
        $atualizando = $dbDB->prepare("DELETE FROM aprovacao WHERE id_visitante = :id_visitante");
        $atualizando->bindValue(':id_visitante', $id, PDO::PARAM_INT);
        if ($atualizando->execute()) {
            $_SESSION['atualizado_sucesso'] = "Visitantes aprovados, mas que foram editados, precisam ser aprovados novamente.";
            header("Location: ../View/home.php");
        } else {
            echo "Erro ao excluir o registro.";
        }
    } else {
        $_SESSION['atualizado_sucesso'] = "Atualizado com sucesso";
        header("Location: ../View/home.php");
    }
}
