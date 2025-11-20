<?php
session_start();
var_dump($_SESSION);

include "conexaoBanco.php";

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Você precisa estar logado para responder o teste.');window.location.href='logar.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_teste = 1;  
    $respostas = $_POST['resposta']; 
  

    foreach ($respostas as $id_questao => $valor) {
        $valor = (int) $valor;

        $respostaTexto = match($valor) {
            10 => 'Discordo',
            15 => 'Discordo Parcialmente',
            5 => 'Neutro',
            20 => 'Concordo Parcialmente',
            25 => 'Concordo',
            default => 'Neutro',
        };

        $respostaTexto = substr($respostaTexto, 0, 255);

        $stmtAlt = $conn->prepare("SELECT id_alternativa FROM alternativas WHERE textoAlternativa = :texto");
        $stmtAlt->execute([':texto' => $respostaTexto]);
        $id_alternativa = $stmtAlt->fetchColumn();

        if ($id_alternativa === false) {
            echo "Alternativa '$respostaTexto' não encontrada para a questão $id_questao. Pulando...<br>";
            continue;
        }

        $stmt = $conn->prepare("
            INSERT INTO respostas (id_usuario, id_teste, id_questao, id_alternativa, respostaUsuario, dataResposta)
            VALUES (:id_usuario, :id_teste, :id_questao, :id_alternativa, :respostaUsuario, NOW())
        ");

        $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':id_teste' => $id_teste,
            ':id_questao' => $id_questao,
            ':id_alternativa' => $id_alternativa,
            ':respostaUsuario' => $respostaTexto
        ]);

    }

    echo "<script> window.location.href='../interface/calculoAptidao.php';</script>";


} else {
    echo "<script>alert('Acesso inválido.');window.location.href='../interface/questoes.php';</script>";
    exit;
}
?>

