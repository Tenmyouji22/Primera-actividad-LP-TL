<?php

$dsn      = 'pgsql:host=localhost;port=5432;dbname=escuela';
$usuario  = 'escuela_user';
$clave    = 'escuela_pass';

$errores = [];
$mensaje = '';
$nombre  = '';
$correo  = '';
$edad    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Captura y validación de los datos
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $edad   = trim($_POST['edad'] ?? '');

    if ($nombre === '' || mb_strlen($nombre) > 100) {
        $errores[] = 'El nombre es obligatorio (máximo 100 caracteres).';
    }
    if (filter_var($correo, FILTER_VALIDATE_EMAIL) === false) {
        $errores[] = 'El correo no es válido.';
    }
    $edadValida = filter_var($edad, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 120],
    ]);
    if ($edadValida === false) {
        $errores[] = 'La edad debe ser un número entero entre 1 y 120.';
    }

    // 2. Inserción con sentencia preparada
    if (empty($errores)) {
        $sql = 'INSERT INTO estudiantes (nombre, correo, edad)
                VALUES (:nombre, :correo, :edad)';
        try {
            $pdo = new PDO($dsn, $usuario, $clave, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false, 
            ]);

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindValue(':edad', $edadValida, PDO::PARAM_INT);
            $stmt->execute();

            $mensaje = 'Alumno registrado correctamente.';
            $nombre = $correo = $edad = '';
        } catch (PDOException $e) {
            $mensaje = 'Datos validados. No hay conexión a la base de datos, '
                     . 'así que el registro se simuló con la sentencia preparada.';
        }
    }
}

// Escapa la salida para evitar XSS al volver a mostrar datos del usuario
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de alumno</title>
</head>
<body>
    <h1>Registrar nuevo alumno</h1>

    <?php if ($mensaje !== ''): ?>
        <p><strong><?= e($mensaje) ?></strong></p>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" maxlength="100" required
               value="<?= e($nombre) ?>"><br><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required
               value="<?= e($correo) ?>"><br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" min="1" max="120" required
               value="<?= e($edad) ?>"><br><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
