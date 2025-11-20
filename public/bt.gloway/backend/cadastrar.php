<?php
file_put_contents('log.txt', "Chegou no cadastrar\n", FILE_APPEND);

include "conexaoBanco.php";

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$senhaCript = password_hash($senha, PASSWORD_DEFAULT);

if (empty($email) || empty($senha)) {
    echo "<script>alert('Há dados não preenchidos. Por favor, preencha todos os campos.');history.go(-1);</script>";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('E-mail inválido.');history.go(-1);</script>";
    exit;
}

$dado = $conn->prepare('SELECT * FROM usuarios WHERE emailUsuario = :email');
$dado->execute([':email' => $email]);

if ($dado->rowCount() == 1) {
    echo "<script>alert('Esse e-mail já está cadastrado.');history.go(-1);</script>";
    exit;
}

try {
    $dado = $conn->prepare('INSERT INTO usuarios (emailUsuario, senha_hash) VALUES (:email, :senha)');
    $dado->execute([
        ':email' => $email,
        ':senha' => $senhaCript
    ]);

    if ($dado->rowCount() == 1) {
        echo "<script>alert('Cadastrado com sucesso! Faça o login.');window.location.href='../interface/login.html';</script>";
    } else {
        echo "<script>alert('Erro: o usuário não foi cadastrado.');history.go(-1);</script>";
    }
    
} catch (PDOException $e) {
    echo "Erro no banco: " . $e->getMessage();
    exit;
}
?>
