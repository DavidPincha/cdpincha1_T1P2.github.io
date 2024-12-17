<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Interactivo</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Menú Interactivo</h1>
        <div class="card shadow p-4">
            <?php
            // Función Fibonacci
            function fibonacci($n) {
                $fib = [1, 1];
                for ($i = 2; $i < $n; $i++) {
                    $fib[] = $fib[$i - 1] + $fib[$i - 2];
                }
                return $fib;
            }

            // Función Cubo de Dígitos
            function cubo_digitos() {
                define("MAX", 1000000);
                $resultados = [];
                for ($i = 1; $i <= MAX; $i++) {
                    $suma = 0;
                    $num_str = (string)$i;
                    for ($j = 0; $j < strlen($num_str); $j++) {
                        $suma += pow((int)$num_str[$j], 3);
                    }
                    if ($suma == $i) {
                        $resultados[] = $i;
                    }
                }
                return $resultados;
            }

            // Función Fraccionarios
            function fraccionarios($fracciones) {
                $resultado = $fracciones[0];
                $resultado += $fracciones[1] * $fracciones[2] - $fracciones[3];
                return $resultado;
            }

            // Captura de opción
            $opcion = isset($_POST['opcion']) ? strtoupper($_POST['opcion']) : null;

            if ($opcion == 'S') {
                header("Location: index.html");
                exit();
            }
            ?>

            <!-- Menú -->
            <form method="post">
                <h3 class="mb-3">MENÚ</h3>
                <ul class="list-group mb-4">
                    <li class="list-group-item">1. Fibonacci</li>
                    <li class="list-group-item">2. Cubo de dígitos</li>
                    <li class="list-group-item">3. Fraccionarios</li>
                    <li class="list-group-item">S. Salir</li>
                </ul>
                <div class="form-group">
                    <label for="opcion">Escoja una opción:</label>
                    <input type="text" name="opcion" class="form-control" id="opcion" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Enviar</button>
            </form>

            <!-- Resultados -->
            <?php
            if ($opcion == '1') { // Fibonacci
                echo '<h4 class="mt-4">Serie de Fibonacci</h4>';
                echo '<form method="post">';
                echo '<div class="form-group">';
                echo '<label for="fibonacci">Ingrese un número entero positivo (1-50):</label>';
                echo '<input type="number" name="fibonacci" class="form-control" required>';
                echo '<input type="hidden" name="opcion" value="1">';
                echo '</div>';
                echo '<button type="submit" class="btn btn-success">Calcular</button>';
                echo '</form>';

                if (isset($_POST['fibonacci'])) {
                    $n = (int)$_POST['fibonacci'];
                    if ($n > 0 && $n <= 50) {
                        $fib = fibonacci($n);
                        echo '<p class="mt-3">Los primeros ' . $n . ' números de Fibonacci son:</p>';
                        echo '<p>' . implode(', ', $fib) . '</p>';
                    } else {
                        echo '<div class="alert alert-danger mt-3">Ingrese un número entre 1 y 50.</div>';
                    }
                }
            } elseif ($opcion == '2') { // Cubo de Dígitos
                echo '<h4 class="mt-4">Números que cumplen la suma de cubos</h4>';
                $cubos = cubo_digitos();
                echo '<p class="mt-3">Los números que cumplen la condición son:</p>';
                echo '<p>' . implode(', ', $cubos) . '</p>';
            } elseif ($opcion == '3') { // Fraccionarios
                echo '<h4 class="mt-4">Cálculo de fraccionarios</h4>';
                echo '<form method="post">';
                $labels = ['A', 'B', 'C', 'D'];
                foreach ($labels as $key => $label) {
                    echo '<div class="form-group">';
                    echo '<label>Fracción ' . $label . ' (numerador/denominador):</label>';
                    echo '<input type="text" name="frac[]" class="form-control" required>';
                    echo '</div>';
                }
                echo '<input type="hidden" name="opcion" value="3">';
                echo '<button type="submit" class="btn btn-success">Calcular</button>';
                echo '</form>';

                if (isset($_POST['frac'])) {
                    $fracciones = array_map(function ($frac) {
                        list($num, $den) = explode('/', $frac);
                        if ($den <= 0) {
                            echo '<div class="alert alert-danger">El denominador debe ser mayor que 0.</div>';
                            exit();
                        }
                        return $num / $den;
                    }, $_POST['frac']);
                    $resultado = fraccionarios($fracciones);
                    echo '<p class="mt-3">El resultado de la expresión A + B * C - D es: ' . number_format($resultado, 4) . '</p>';
                }
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
