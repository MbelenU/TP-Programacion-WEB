<?php
    session_start();
    require_once __DIR__ . '/../../controllers/UsuarioController.php';
    $usuarioController = new UsuarioController();
    $error = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);
        $resultado = $usuarioController->iniciarSesion($email, $password);
        if($resultado) {
            $_SESSION['user'] = $resultado;
            switch($resultado['user_type']) {
                case 'Alumno':
                    header("Location: ./alumno-perfil.php");
                    exit();
                case 'Admin':
                    header("Location: ./admin-perfil.php");
                    exit();
                case 'Empresa':
                    header("Location: ./empresa-perfil.php");
                    exit();
                default:
                    header("Location: ./error.php");
                    exit();
            }
        }else {
            $error = "Credenciales incorrectas. Por favor, intenta de nuevo.";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/global.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <title>Iniciar Sesión</title>
</head>
<body class="bg-inicio ">
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="col-sm-4 rounded-5 p-4 bg-opacity-75 w-auto shadow-lg bg-navbar">
            <div class="text-center mb-3 p-3">
                <img src="../img/logo.png" alt="logo" class="img-fluid">
            </div>
            <form method="POST" id="form-inicio" class="g-3" novalidate>
                <h2 class="text-center mb-4 mx-sm-5 px-sm-5">Iniciar Sesión</h2>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <div class="form-floating mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Ej: usuario@gmail.com" required>
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Ej: contraseña123" required>
                    <label for="password">Password</label>
                </div>
                <div class="mb-3 text-end">
                    <a href="forgot-password.html" class="text-secondary">Olvidé mi contraseña</a>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" name="login">Iniciar Sesión</button>
                    <a href="register.php" class="btn btn-secondary">Registrarse</a>
                </div>

            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>