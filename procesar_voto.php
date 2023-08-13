<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mt-5">
        <div class="form-container">
            <!-- Contenido del formulario como antes -->

            <!-- Enlace para volver atrás -->
            <button type="button" class="btn btn-secondary mt-3" onclick="goBack()">Volver Atrás</button>
        </div>
    </div>
    
    <!-- script para volver atras -->

    <script>
        // Función para volver atrás
        function goBack() {
            window.history.back();
        }
    </script>
    
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "desis";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$alias = $_POST['alias'];
$rut = $_POST['rut'];
$email = $_POST['email'];
$region = $_POST['region'];
$comuna = $_POST['comuna'];
$candidato = $_POST['candidato'];
$como_se_entero = $_POST['como_se_entero'];

// Validar la duplicación de votos por RUT
$sqlDuplicado = "SELECT COUNT(*) AS total FROM votos WHERE rut = '$rut'";
$resultDuplicado = $conn->query($sqlDuplicado);

if ($resultDuplicado && $resultDuplicado->num_rows > 0) {
    $row = $resultDuplicado->fetch_assoc();
    if ($row['total'] > 0) {
        die("Error: Ya existe un voto registrado con este RUT.");
    }
}

// Insertar el voto en la base de datos
$sqlInsert = "INSERT INTO votos (nombre, alias, rut, email, region, comuna, candidato, como_se_entero)
              VALUES ('$nombre', '$alias', '$rut', '$email', '$region', '$comuna', '$candidato', '$como_se_entero')";

if ($conn->query($sqlInsert) === TRUE) {
    echo "Voto registrado exitosamente.";
} else {
    echo "Error al registrar el voto: " . $conn->error;
}

$conn->close();
?>
