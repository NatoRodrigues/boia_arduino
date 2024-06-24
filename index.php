<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados do Sensor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sensor-data {
            margin-bottom: 20px;
        }
        .sensor-data p {
            margin: 10px 0;
        }
        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dados do Sensor</h1>
        <div class="sensor-data">
            <p><strong>Estado do Sensor:</strong> <span id="estadoSensor"></span></p>
            <p><strong>Volume Adicionado:</strong> <span id="volumeAdicionado"></span> ml</p>
            <p><strong>Volume Total:</strong> <span id="volumeTotal"></span> ml</p>
         </div>
        <p class="error-message" id="errorMessage"></p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function getSensorData() {
            $.ajax({
                url: 'app/controller/getSensorData.php',  
                method: 'GET',
                success: function(response) {
                    $('#estadoSensor').text(response.data.estado_sensor ? 'Água Presente' : 'Água Ausente');
                    $('#volumeAdicionado').text(response.data.volume_adicionado.toFixed(2));
                    $('#volumeTotal').text(response.data.volume_total.toFixed(2));
                 
                    $('#errorMessage').text('');
                },
                error: function(xhr, status, error) {
                    $('#errorMessage').text('Erro ao buscar os dados do sensor: ' + error);
                }
            });
        }

        setInterval(getSensorData, 1000);
    </script>
</body>
</html>
