
<?php

include("dados.php");

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if (empty($usuario)) {
        echo "Error: The 'usuario' field is required.";
    } elseif ($senha!== $confirma_senha) {
        echo "Error: As senhas não coincidem.";
    } else {
        // Criptografar a senha usando password_hash()
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        // Verificar se o email já existe no banco de dados
        $stmt = $conexao->prepare("SELECT COUNT(*) FROM usuarios WHERE email =?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['COUNT(*)'] > 0) {
            // Email já existe, exibir mensagem de erro e interromper o cadastro
            echo "Erro: O email já está cadastrado no banco de dados.";
        } else {
            // Email não existe, inserir os dados do usuário no banco de dados
            $stmt = $conexao->prepare("INSERT INTO usuarios (usuario, email, senha) VALUES (?,?,?)");
            $stmt->bind_param("sss", $usuario, $email, $senha_criptografada);
            $stmt->execute();

            // Verificar se os dados foram inseridos com sucesso
            if ($stmt->affected_rows > 0) {
                echo "Usuário cadastrado com sucesso.";
            } else {
                echo "Error: ". $conexao->error;
            }
        }
    }
}

// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>