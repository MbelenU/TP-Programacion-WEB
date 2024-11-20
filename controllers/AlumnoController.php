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
        // $password = $_POST['contraseña'] ? $_POST['contraseña'] : NULL;
        $nombre = $_POST['nombre'] ? $_POST['nombre'] : NULL ;
        $apellido = $_POST['apellido'] ? $_POST['apellido'] : NULL ;
        $telefono = $_POST['telefono'] ? $_POST['telefono'] : NULL;
        // $username = $_POST['username'] ? $_POST['username'] : NULL;
        // $habilidades = $_POST['habilidadesSeleccionadas'] ? $_POST['habilidadesSeleccionadas'] : NULL;
        $habilidadesIds =$_POST['habilidadesSeleccionadas'] ? explode(",", $_POST['habilidadesSeleccionadas']) : [];
        $carrera = $_POST['carrera'] ? $_POST['carrera'] : NULL;
        $planEstudios = /*$_POST['planEstudios'] ? $_POST['planEstudios'] : */NULL;
        $materias = /*$_POST['materia'] ? $_POST['materia'] : */NULL;
        $direccion = $_POST['direccion'] ? $_POST['direccion'] : NULL;
        $deBaja = NULL;
        $foto_perfil = null;
        if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] === UPLOAD_ERR_OK) {
            
            $fileTmpPath = $_FILES['fotoPerfil']['tmp_name'];
            $fileName = $_FILES['fotoPerfil']['name'];
            $newFileName = uniqid('profile_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $uploadDir = './../img/';
            $uploadPath = $uploadDir . $newFileName;
    
            
            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $foto_perfil = $newFileName;
            }
        } else {
            $foto_perfil = null; 
        }

        $check = $this->alumnoDao->editarPerfilAlumno($id, $email, $nombre, $apellido, $telefono, $direccion, $foto_perfil, $deBaja, $habilidadesIds, $planEstudios, $materias);

        if ($check) {
            return [
                'success' => true,
                'body' => $check,
            ];
        } else {
            return [
                'success' => false,
                'body' => 'Error',
            ];
        }

    }
    public function obtenerPlanesEstudio() {
        $id = $_GET['id_carrera'];
        $planesEstudio = $this->alumnoDao->obtenerPlanesEstudio($id);
        if($planesEstudio){
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "body" => $planesEstudio
            ]);
            return;
        }
        else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se encontraron planes estudio para esta carrera',
            ]);
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

    public function listarEmpleos(){
        $empleos = $this->alumnoDao->getEmpleos();
        if($empleos){
            $response = [
                "success" => true,
                "body" => $empleos
            ];
            return $response;
        }
        else {
            
            $response = [
                'success' => false,
                'message' => 'Error: No se encontraron empleos',
            ];
            return $response;
        }
    }

    public function buscarEmpleos(){
        $empleos = $this->alumnoDao->getBusquedaEmpleo();
        if($empleos){
            
            $response = [
                "success" => true,
                "body" => $empleos
            ];
            return $response;
        }
        else {
            
            $response = [
                'success' => false,
                'message' => 'Error: No se encontraron empleos',
            ];
            return $response;
        }
    }


    public function listarPostulaciones(){
        $postulaciones = $this->alumnoDao->getPostulaciones();
        if($postulaciones){
            
            $response = [
                "success" => true,
                "body" => $postulaciones
            ];
            return $response;
        }
        else {
            
            $response = [
                'success' => false,
                'message' => 'Error: No se encontraron solicitudes',
            ];
            return $response;
        }
    }

    public function verificarSuscripcion() {
        $suscripcion = $this->alumnoDao->getSuscripciones();
        if($suscripcion){
            
            $response = [
                "success" => true,
                "body" => $suscripcion
            ];
            return $response;
        }
        else {
            
            $response = [
                'success' => false,
                'message' => 'Error: No se encontraron suscripciones',
            ];
            return $response;
        }
    }
    

    public function obtenerAlumnoPorId($id){
        $usuario = $this->alumnoDao->obtenerAlumno($id);
        if($usuario){
            
            $response = [
                "success" => true,
                "body" => $usuario
            ];
            return $response;
        }
        else {
            
            $response = [
                'success' => false,
                'message' => 'Error: No se encontraron solicitudes',
            ];
            return $response;
        }
    }

    public function listarCarreras(){
        $carreras = $this->alumnoDao->listarCarreras();
        if($carreras){
            return [
                "success" => true,
                "body" => $carreras
            ];
        }
        else {
            return [
                'success' => false,
                'message' => 'Error: No se encontraron carreras',
            ];
        }
    }
    
}
?>


