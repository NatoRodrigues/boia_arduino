<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    if ($data) {
        $estadoSensor = $data['estado_sensor'];
        $volumeAdicionado = $data['volume_adicionado'];
        $volumeTotal = $data['volume_total'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dados_boia";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        $sql = "INSERT INTO sensor_data (estado_sensor, volume_adicionado, volume_total)
                VALUES (?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("idd", $estadoSensor, $volumeAdicionado, $volumeTotal);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(["message" => "Dados inseridos com sucesso"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao inserir os dados: " . $stmt->error]);
            }

            $stmt->close();
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Preparação da declaração falhou: " . $conn->error]);
        }

        $conn->close();
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Dados inválidos"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Método não permitido"]);
}

?>
