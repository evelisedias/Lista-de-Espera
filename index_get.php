<?php

// Dados do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "lista_de_clientes";

// Definir quantos resultados por página
$resultados_por_pagina = 10;

// Verificar se o parâmetro de página está definido na URL, se não, definir como 1
$pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Criando conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verificando conexão
if ($conn->connect_errno) {
    die("Conexão falhou: " . $conn->connect_errno);
} else {
    //echo '<div class="conexao">' . "Conexão bem sucedida!" . '</div>';
}

// Consulta SQL para contar o número total de registros
$query_total_registros = "SELECT COUNT(*) as total_registros FROM clientes";
$resultado_total_registros = $conn->query($query_total_registros);
$row_total_registros = $resultado_total_registros->fetch_assoc();
$total_registros = $row_total_registros['total_registros'];

// Calcular o número total de páginas
$total_paginas = ceil($total_registros / $resultados_por_pagina);

// Calcular o ponto de partida para a consulta SQL baseado na página atual
$inicio = ($pagina_atual - 1) * $resultados_por_pagina;

// Consulta SQL para buscar os dados com limite de resultados por página e ponto de partida
$query = "SELECT ordem, nome, telefone FROM clientes LIMIT $inicio, $resultados_por_pagina";
$dados = $conn->query($query);

if ($dados->num_rows > 0) {
    while ($linha = $dados->fetch_assoc()) {
        echo '<p>' . $linha['ordem'] . " " . $linha['nome'] . '</p>';
    }
} else {
    echo "Nenhum resultado encontrado.";
}

// Exibir links para páginas anteriores e próximas
if ($pagina_atual > 1) {
    echo '<a href="?pagina=' . ($pagina_atual - 1) . '">Página Anterior</a>';
}

for ($i = 1; $i <= $total_paginas; $i++) {
    echo '<a href="?pagina=' . $i . '">' . $i . '</a> ';
}

if ($pagina_atual < $total_paginas) {
    echo '<a href="?pagina=' . ($pagina_atual + 1) . '">Próxima Página</a>';
}


$conn->close();
?>