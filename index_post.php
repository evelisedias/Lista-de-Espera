<?php

include ("new_clients.html");
// Dados do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "lista_de_clientes";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verificando a conexão
if ($conn->connect_errno) {
    die("Conexão falhou: " . $conn->connect_errno);
} else {
    echo '<div class="conexao">' . "Conexão bem sucedida!" . '</div>';
}

// Verificando formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtendo dados
    $name = $_POST["name"];
    $phone = $_POST["phone"];

    // Criando tabela no db
    $sql = "INSERT INTO clientes 
    (Nome, Telefone) VALUES ('$name', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo '<div class="conexao">' . "Dados inseridos com sucesso. Redirecionando em 5 segundos..." . '</div>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "new_clients.html";
                }, 5000); // 10 segundos
              </script>';
        exit(); // Certifique-se de parar a execução do script após redirecionar
    } else {
        echo '<div class="conexao">' . "Erro ao inserir dados: " . '</div>' . $conn->errno;
    }
}

?>
