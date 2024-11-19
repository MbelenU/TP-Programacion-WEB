<?php
session_start();
require_once __DIR__ . '/../../controllers/EmpresaController.php';
$empresaController = new EmpresaController();

if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

$allowedRoles = ['3'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}

$alumno = $empresaController->obtenerAlumno($_GET['id']);

if (!$alumno['success']) {
    echo "<div class='alert alert-danger'>Alumno no existe.</div>";
    exit();
}
$alumno = $alumno['body'];

function mostrarValor($valor, $mensaje = 'No disponible') {
    return htmlspecialchars($valor ?? $mensaje);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/global.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/empresa.css">
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/empresa-navbar.php' ?>

    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
            <div class="perfil-header d-flex align-items-center mb-4">
                <?php
                $fotoPerfil = $alumno->getFotoDePerfil() ? BASE_URL . htmlspecialchars($alumno->getFotoDePerfil()) : 'ruta-a-imagen-default.jpg';
                ?>
                <img src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil" id="foto-perfil" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; margin-right: 20px;">
                
                <div class="info">
                    <div class="nombre mb-3">
                        <h1><?php echo htmlspecialchars($alumno->getNombreAlumno() . ' ' . $alumno->getApellidoAlumno()); ?></h1>
                    </div>
                    <div class="descripcion mb-3">
                        <p><?php echo mostrarValor($alumno->getDescripcion()); ?></p>
                    </div>
                    <button class="btn btn-outline-success">Descargar CV</button>
                </div>
            </div>

            <div class="contact-info mb-5">
                <div class="info-item mb-4">
                    <i class="bi bi-geo-alt"></i>
                    <span><?php echo mostrarValor($alumno->getDireccion()); ?></span>
                </div>
                <div class="info-item mb-4">
                    <i class="bi bi-phone"></i>
                    <span><?php echo mostrarValor($alumno->getTelefono()); ?></span>
                </div>
                <div class="info-item mb-4">
                    <i class="bi bi-book"></i>
                    <span>
                        <?php 
                        $carrera = $alumno->getCarrera();
                        echo $carrera ? htmlspecialchars($carrera->getNombreCarrera()) : 'Carrera no asignada'; 
                        ?>
                    </span>
                </div>
                <div class="info-item mb-4">
                    <i class="bi bi-envelope"></i>
                    <span><?php echo mostrarValor($alumno->getEmail()); ?></span>
                </div>
            </div>

            <section class="habilidades mb-5">
                <h2 class="mb-4">Habilidades</h2>
                <ul>
                <?php
                    $habilidades = $alumno->getHabilidades();
                    if ($habilidades && count($habilidades) > 0) {
                        foreach ($habilidades as $habilidad) {
                            $nombreHabilidad = htmlspecialchars($habilidad->getNombreHabilidad());
                            $nivelHabilidad = (int) $habilidad->getNivelHabilidad();
                            

                            // Generar estrellas
                            $estrellas = '';
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < $nivelHabilidad) {
                                    $estrellas .= '<i class="bi bi-star-fill text-warning"></i>';
                                } else {
                                    $estrellas .= '<i class="bi bi-star text-muted"></i>';
                                }
                            }

                            echo '<li class="mb-3">' . $nombreHabilidad . ' ' . $estrellas . '</li>';
                        }
                    } else {
                        echo '<li class="mb-3">No tiene habilidades registradas</li>';
                    }
                ?>
                </ul>
            </section>

            <section class="materias-aprobadas mb-5">
                <h2 class="mb-4">Avance Académico</h2>
                <ul>
                    <?php
                    $materiasAprobadas = $alumno->getMateriasAprobadas();
                    if ($materiasAprobadas && count($materiasAprobadas) > 0) {
                        foreach ($materiasAprobadas as $materia) {
                            echo '<li class="mb-3">' . htmlspecialchars($materia) . '</li>';
                        }
                    } else {
                        echo '<li class="mb-3">No tiene materias aprobadas registradas</li>';
                    }
                    ?>
                </ul>
            </section>
        </div>
    </div>
</body>

</html>
