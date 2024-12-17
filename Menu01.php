<?php

// Cálculo del factorial
function factorial($n)
{
    $resultado = 1;
    for ($i = 1; $i <= $n; $i++) {
        $resultado *= $i;
    }
    return $resultado;
}

// Verificar si el número es primo
function esPrimo($n)
{
    if ($n < 2) return false;
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false;
    }
    return true;
}

// Calcular la serie matemática
function calcularSerie($terminos)
{
    $resultado = 0;
    $signo = 1; // Alterna entre positivo y negativo
    for ($i = 1; $i <= $terminos; $i++) {
        $numerador = pow($i, 2);  // i^2
        $denominador = factorial($i);  // i!
        $resultado += $signo * ($numerador / $denominador);
        $signo *= -1;  // Cambia de signo
    }
    return round($resultado, 4);
}

// Inicialización de variables
$opcion = $resultado = "";
$numero = $terminos = null;

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $opcion = $_POST["opcion"] ?? "";
    $numero = isset($_POST["numero"]) ? (int)$_POST["numero"] : null;
    $terminos = isset($_POST["terminos"]) ? (int)$_POST["terminos"] : null;

    if ($numero !== null && ($numero < 0 || $numero > 10)) {
        $resultado = "<div class='alert alert-danger'>El número debe estar entre 0 y 10.</div>";
    } else {
        switch ($opcion) {
            case '1': // Factorial
                $resultado = "<div class='alert alert-info'>El factorial de $numero es: <strong>" . factorial($numero) . "</strong></div>";
                break;
            case '2': // Primo
                $resultado = esPrimo($numero)
                    ? "<div class='alert alert-success'>$numero es un número primo.</div>"
                    : "<div class='alert alert-warning'>$numero no es un número primo.</div>";
                break;
            case '3': // Serie matemática
                if ($terminos !== null && $terminos > 0) {
                    $resultado = "<div class='alert alert-primary'>El resultado de la serie con $terminos términos es: <strong>" . calcularSerie($terminos) . "</strong></div>";
                } else {
                    $resultado = "<div class='alert alert-danger'>Ingrese un número válido de términos para la serie.</div>";
                }
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Operaciones</title>
    <!-- Cargar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Función para manejar la redirección al hacer clic en SALIR
        function salir() {
            window.location.href = "index.html";
        }

        // Mostrar u ocultar la cantidad de términos según la opción seleccionada
        function mostrarTerminos() {
            const opcion = document.querySelector("select[name='opcion']").value;
            const terminosDiv = document.getElementById("terminos-div");

            if (opcion === "3") { // Si la opción seleccionada es la serie matemática
                terminosDiv.style.display = "block";
            } else {
                terminosDiv.style.display = "none";
            }

            // Si la opción seleccionada es SALIR
            if (opcion === "S") {
                salir(); // Llama a la función salir inmediatamente
            }
        }
    </script>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Menú de Operaciones</h3>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <!-- Selección de opción -->
                    <div class="col-md-12">
                        <label class="form-label">Seleccione una opción:</label>
                        <select name="opcion" class="form-select" required onchange="mostrarTerminos()">
                            <option value="" disabled selected>Seleccione...</option>
                            <option value="1">Calcular Factorial</option>
                            <option value="2">Verificar Primo</option>
                            <option value="3">Calcular Serie Matemática</option>
                            <option value="S">Salir</option>
                        </select>
                    </div>

                    <!-- Número de entrada -->
                    <div class="col-md-6">
                        <label for="numero" class="form-label">Ingrese un número (0 - 10):</label>
                        <input type="number" id="numero" name="numero" class="form-control" min="0" max="10" required>
                    </div>

                    <!-- Términos de la serie (inicialmente oculto) -->
                    <div class="col-md-6" id="terminos-div" style="display: none;">
                        <label for="terminos" class="form-label">Cantidad de términos (para la serie):</label>
                        <input type="number" id="terminos" name="terminos" class="form-control" min="1" max="10">
                    </div>

                    <!-- Botón de envío -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Calcular</button>
                    </div>
                </form>
            </div>

            <!-- Resultado -->
            <?php if ($resultado): ?>
                <div class="card-footer text-center">
                    <?php echo $resultado; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>