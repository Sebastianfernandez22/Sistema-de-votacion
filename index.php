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



// Crear un array para almacenar los datos de los candidatos
$candidatos = array();
$sqlComunas = "SELECT codigointerno, nombre, padre FROM comunas";
$resultComunas = $conn->query($sqlComunas);

$comunasData = array();
if ($resultComunas->num_rows > 0) {
    while ($comuna = $resultComunas->fetch_assoc()) {
        $comunasData[] = $comuna;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Formulario de Votación</title>
    <style>
    /* Estilos */
    body {
        font-family: Arial, sans-serif;
    }

    .form-container {
        max-width: 500px;
        margin: 0 auto;
    }

    .form-check {
        display: flex;
        align-items: auto;
        margin-bottom: 10px;
    }

    .form-check label {
        flex-basis: 25%;
        margin-right: 9px;
        text-align: right;
    }

    .form-check input {
        flex: 10;
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-left: 10px;
    }

    .radio-container {
        display: flex;
        align-items: center;
    }

    .radio-container label {
        margin-right: 30px;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Formulario de Votación</h1>
        <form action="procesar_voto.php" method="post">

            <!-- Nombre y Apellido -->
            <div class="form-check">
                <label for="nombre">Nombre y Apellido:</label>
                <input type="text" name="nombre" required>
            </div>

            <!-- Alias -->
            <div class="form-check">
                <label for="alias">Alias:</label>
                <input type="text" id="alias" name="alias" required>
                <span id="alias-error" class="error-message"></span>
            </div>

            <!-- RUT -->
            <div class="form-check">
                <label for="rut">RUT:</label>
                <input type="text" name="rut" id="rut" required oninput="validarRut(this);">
            </div>

            <!-- Email -->
            <div class="form-check">
                <label for="email">Email:</label>
                <input type="email" name="email" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}">
            </div>

            <!-- ComboBox de Región -->
            <div class="form-check">
                <label for="region">Selecciona una región:</label>
                <select id="region" name="region">
                    <option value="">Selecciona una región</option>
                    <?php
                    // Consulta SQL para obtener las regiones activas
                    $sqlRegiones = "SELECT codigo, nombre FROM regiones WHERE activo = 1 ORDER BY orden";
                    $resultRegiones = $conn->query($sqlRegiones);

                    if ($resultRegiones->num_rows > 0) {
                        while ($region = $resultRegiones->fetch_assoc()) {
                            echo '<option value="' . $region['codigo'] . '">' . $region['nombre'] . '</option>';
                        }
                    }
                    ?>
                </select>

                
            </div>

            <!-- ComboBox de Comuna -->
            <div class="form-check">
                <label for="comuna">Selecciona una comuna:</label>
                <select id="comuna" name="comuna">
                    <option value="">Selecciona una comuna</option>
                    <?php
                    // Código para cargar opciones de comunas
                    ?>
                </select>
            </div>

         <!-- Candidatos -->
<div class="form-check">
    <label for="candidato">Candidatos:</label>
    <select id="candidato" name="candidato" required>
        <option value="">Selecciona un Candidato</option>
        <?php
        // Consulta SQL para obtener los candidatos
        $sql = "SELECT id, nombre FROM candidatos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($candidato = $result->fetch_assoc()) {
                echo '<option value="' . $candidato['id'] . '">' . $candidato['nombre'] . '</option>';
            }
        }
        ?>
    </select>
</div>


            


            <!-- Selección de cómo se enteró de nosotros -->
            <div class="form-check">
                <label>¿Cómo se enteró de nosotros?</label>
                <div class="checkbox-container">
                    <input type="checkbox" id="web" name="como_se_entero[]" value="web">
                    <label for="web">Web</label>

                    <input type="checkbox" id="tv" name="como_se_entero[]" value="tv">
                    <label for="tv">TV</label>

                    <input type="checkbox" id="redes_sociales" name="como_se_entero[]" value="redes_sociales">
                    <label for="redes_sociales">Redes Sociales</label>

                    <input type="checkbox" id="amigo" name="como_se_entero[]" value="amigo">
                    <label for="amigo">Amigo</label>
                </div>
                <span id="como_se_entero_error" class="error-message"></span>
            </div>

            <!-- Botón de Votar -->
            <input type="submit" name="votar" value="Votar">
        </form>
    </div>


    <!-- Script para validar el RUT (Formato Chile) -->
    <script>
    function validarRut(input) {
        var rut = input.value.replace(/[.-]/g, ''); // Eliminar puntos y guiones
        var cuerpoRut = rut.slice(0, -1);
        var digitoVerificador = rut.slice(-1).toUpperCase();

        var cuerpoSum = 0;
        var multiplicador = 2;

        // Calcular suma ponderada del cuerpo del RUT
        for (var i = cuerpoRut.length - 1; i >= 0; i--) {
            cuerpoSum += parseInt(cuerpoRut.charAt(i)) * multiplicador;
            multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
        }

        var resto = cuerpoSum % 11;
        var dvCalculado = 11 - resto;
        var dvEsperado = dvCalculado === 10 ? 'K' : (dvCalculado === 11 ? '0' : dvCalculado.toString());

        if (dvEsperado === digitoVerificador) {
            input.setCustomValidity('');
        } else {
            input.setCustomValidity('RUT inválido');
        }
    }
    </script>

    <!-- Validación de Alias -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const aliasInput = document.getElementById('alias');
        const aliasError = document.getElementById('alias-error');

        aliasInput.addEventListener('input', function() {
            const aliasValue = aliasInput.value;

            if (aliasValue.length > 5 && /^[a-zA-Z0-9]+$/.test(aliasValue)) {
                aliasInput.setCustomValidity('');
                aliasError.textContent = '';
            } else {
                aliasInput.setCustomValidity('Alias inválido');
                aliasError.textContent =
                    'El alias debe tener al menos 6 caracteres y contener solo letras y números.';
            }
        });
    });
    </script>

    <!-- Cargar opciones de comunas basadas en la región seleccionada -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const regionSelect = document.getElementById('region');
        const comunaSelect = document.getElementById('comuna');
        const comunasData = <?php echo json_encode($comunasData); ?>;

        regionSelect.addEventListener('change', () => {
            const selectedRegionId = regionSelect.value;
            comunaSelect.innerHTML = '<option value="">Selecciona una comuna</option>';

            if (selectedRegionId) {
                comunasData.forEach(function(comuna) {
                    if (comuna.padre == selectedRegionId) {
                        const option = document.createElement('option');
                        option.value = comuna.codigointerno; // Cambiar a la columna correcta
                        option.textContent = comuna.nombre;
                        comunaSelect.appendChild(option);
                    }
                });
            }
        });
    });
    </script>

    <!-- Validación de cómo se enteró de nosotros -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxInputs = document.querySelectorAll('input[name="como_se_entero[]"]');
        const comoSeEnteroError = document.getElementById('como_se_entero_error');

        checkboxInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                const selectedOptions = Array.from(checkboxInputs).filter(function(checkbox) {
                    return checkbox.checked;
                });

                if (selectedOptions.length < 2) {
                    comoSeEnteroError.textContent = 'Selecciona al menos dos opciones.';
                } else {
                    comoSeEnteroError.textContent = '';
                }
            });
        });
    });
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



</body>

</html>