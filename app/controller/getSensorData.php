<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dados_boia";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(["message" => "Falha na conexão com o banco de dados: " . $conn->connect_error]);
        exit();
    }

    $sql = "SELECT estado_sensor, volume_adicionado, volume_total FROM sensor_data ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        // Garantir que os valores são numéricos
        $data['volume_adicionado'] = (float)$data['volume_adicionado'];
        $data['volume_total'] = (float)$data['volume_total'];
        http_response_code(200);
        echo json_encode(['data' => $data]);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Dados do sensor não encontrados"]);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["message" => "Método não permitido"]);
}

?>
