<?php
require_once __DIR__ . '/../dal/AlumnoDAO.php';
require_once __DIR__ . '/../models/Alumno.php';
require_once __DIR__ . '/../models/Usuario.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
$alumnoController = new AlumnoController();

$endpoint = $_GET['endpoint'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $endpoint === "register") {
    $resultado = $usuarioController->register();
    return $resultado;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $endpoint === "getHabilidades") {
    $resultado = $alumnoController->getHabilidades();
    return $resultado;
    exit;
}

class AlumnoController {
    private AlumnoDAO $alumnoDao;

    public function __construct() {
        $this->alumnoDao = new AlumnoDAO();
    }

    public function editarPerfilAlumno($id) {
        $email = $_POST['email'] ? $_POST['email'] : NULL;
        $password = $_POST['contraseña'] ? $_POST['contraseña'] : NULL;
        $nombre = $_POST['nombre'] ? $_POST['nombre'] : NULL ;
        $apellido = $_POST['apellido'] ? $_POST['apellido'] : NULL ;
        $telefono = $_POST['telefono'] ? $_POST['telefono'] : NULL;
        $username = $_POST['username'] ? $_POST['username'] : NULL;
        $habilidades = $_POST['habilidadesSeleccionadas'] ? $_POST['habilidadesSeleccionadas'] : NULL;
        $carrera = /* $_POST['carrera'] ? $_POST['carrera'] : */ NULL;
        $planEstudios = /*$_POST['planEstudios'] ? $_POST['planEstudios'] : */NULL;
        $materias = /*$_POST['materia'] ? $_POST['materia'] : */NULL;
        $direccion = $_POST['direccion'] ? $_POST['username'] : NULL;
        $deBaja = NULL;
        $fotoPerfil = NULL;

        $check = $this->alumnoDao->editarPerfilAlumno($id, $email, $username,$password, $nombre, $apellido, $telefono, $direccion, $fotoPerfil, $deBaja, $habilidades, $planEstudios, $materias);

        if ($check) {
            return [
                'success' => true,
                'message' => 'Usuario Editado Correctamente',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error',
            ];
        }

    }

    public function getHabilidades(){
        return $this->alumnoDao->getHabilidades();
    }

    public function listarEventos(){
        $eventos = $this->alumnoDao->getEventos();
        if($eventos){
            
            $response = [
                "success" => true,
                "body" => $eventos
            ];
            return $response;
        }
        else {
            
            $response = [
                'success' => false,
                'message' => 'Error: No se encontraron eventos',
            ];
            return $response;
        }
    }
    
}
?>


