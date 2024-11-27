<?php
session_start();
require_once __DIR__ . '/../../controllers/EmpresaController.php';
$empresaController = new EmpresaController();

if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Visualizar Alumno', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
} 

$alumno = $empresaController->obtenerAlumno($_GET['id']);
$publicaciones = $empresaController->listarPublicaciones();

if (!$alumno['success']) {
    echo "<div class='alert alert-danger'>Alumno no existe.</div>";
    exit();
}
$alumno = $alumno['body'];

$usuarioId = $alumno->getUsuarioId();  

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/empresa/reclutar.js" defer></script>
</head>

<body class="bg-inicio">
    <?php if ($_SESSION['user']['user_type'] == 1){
            require __DIR__ . '/../components/admin-navbar.php';
    } elseif ($_SESSION['user']['user_type'] == 3){
            require __DIR__ . '/../components/empresa-navbar.php';
    }
    ?>

<div id="alumno-info" data-alumno-id="<?php echo $alumno->getUsuarioId(); ?>"></div>

    <div class="container p-sm-4 bg-white">
        <a href="<?php echo BASE_URL ?>views/empresa-reclutar-alumno.php">
            <button type="button" class="btn btn-light mt-3 mb-4">Volver a alumnos</button>
        </a>
        <div class="container mt-5">
        
            <div class="perfil-header d-flex align-items-center mb-4 ">
                <?php
                $fotoPerfil = ($alumno->getFotoPerfil()) ? BASE_URL . 'img/' . htmlspecialchars($alumno->getFotoPerfil()) : BASE_URL . 'img/perfil.jpg';
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
                    <?php if (Permisos::tienePermiso('Reclutar Perfil', $_SESSION['user']['user_id'])){ ?>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalReclutar">
                        Reclutar
                    </button>
                    <?php } ?>
                </div>
            </div>

            <div class="contact-info mb-5">
                <div class="info-item mb-4">
                    <i class="bi bi-geo-alt"></i>
                    <span><?php echo mostrarValor($alumno->getUbicacion()); ?></span>
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
                        echo '<p class="mb-3">-</p>';
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
                        echo '<p class="mb-3">-</p>';
                    }
                    ?>
                </ul>
            </section>
        </div>
    </div>
          <!-- Modal -->
          <div class="modal fade" id="modalReclutar" tabindex="-1" aria-labelledby="modalReclutarLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">

                        <div id="successMessage" class="alert alert-success d-none"></div>
                        <div id="errorMessage" class="alert alert-danger d-none"></div>

                            <label for="publicacionSelect">Elige una publicación</label>
                            <select class="form-select" id="publicacionSelect">
                                <option selected>Selecciona una publicación</option>
                                <?php if (!empty($publicaciones['body'])): ?>  
                                    <?php foreach ($publicaciones['body'] as $publicacion): ?>  
                                        <option value="<?php echo $publicacion->getId(); ?>">
                                            <?php echo htmlspecialchars($publicacion->getTitulo()); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option disabled>No hay publicaciones disponibles</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="guardarReclutamiento">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>

</body>

</html>
