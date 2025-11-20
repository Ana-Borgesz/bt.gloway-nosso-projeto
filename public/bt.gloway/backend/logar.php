<?php
session_start();

include "conexaoBanco.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

$email = $_POST['email'] ?? '';
$senhadigitada = $_POST['senha'] ?? '';

try {
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE emailUsuario = :email");
    $stmt->execute([':email' => $email]);

    if ($stmt->rowCount() === 1) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($senhadigitada, $usuario['senha_hash'])) {
            session_regenerate_id(true);
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            header("Location: ../interface/index.html");
            exit;
        }
    }

} catch (PDOException $e) {
    error_log("Erro de login: " . $e->getMessage());
    echo "<script>alert('Erro no servidor. Tente novamente mais tarde.');history.go(-1);</script>";
    exit;
}
