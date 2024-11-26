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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['aplicarEmpleo'])) {
    session_start();
    $resultado = $alumnoController->aplicarEmpleo();
    return $resultado;
    exit;
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['darBaja'])) {
    $resultado = $alumnoController->darBaja();
    return $resultado;
    exit;
}elseif(isset($_GET['buscarEmpleos'])) {
    session_start();
    $idUsuario = $_SESSION['user']['user_id'];
    $resultado = $alumnoController->buscarEmpleos($idUsuario, $_GET['buscarEmpleos']);
    echo json_encode($resultado);
    exit();
}elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['borrarSuscripcion'])){
    session_start();
    $idUsuario = $_SESSION['user']['user_id'];
    $alumnoController = new AlumnoController();
    $resultado = $alumnoController->eliminarSuscripcion();
    return $resultado;
    exit;
}
elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['agregarSuscripcion'])){
    session_start();
    $idUsuario = $_SESSION['user']['user_id'];
    $alumnoController = new AlumnoController();
    $resultado = $alumnoController->agregarSuscripcion();
    return $resultado;
    exit;
}

class AlumnoController {
    private AlumnoDAO $alumnoDao;

    public function __construct() {
        $this->alumnoDao = new AlumnoDAO();
    }
    public function darBaja() {
        $solicitudId = $_POST['solicitud_id'] ?? null;
        if (empty($solicitudId)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Error: El ID de la solicitud es obligatorio',
            ]);
            return;
        }

        
        $result = $this->alumnoDao->darBaja($solicitudId);

        if ($result) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Solicitud dada de baja exitosamente',
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se pudo dar de baja la solicitud',
            ]);
        }
    }
    public function checkPostulacion($empleoId){
        $idUsuario = $_SESSION['user']['user_id'];
        $id_publicacion = htmlspecialchars($empleoId ?? '');
        $postulacion = $this->alumnoDao->checkPostulacion($idUsuario, $id_publicacion);
        if($postulacion){
            return true;
        }
        else {
            return false;
        }
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
    public function aplicarEmpleo() {
        $idUsuario = $_SESSION['user']['user_id'];

        $input = json_decode(file_get_contents('php://input'), true);
        $id_publicacion = htmlspecialchars($input['empleoId'] ?? '');

        $empleo = $this->alumnoDao->aplicarEmpleo($idUsuario, $id_publicacion);
        if($empleo){
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "body" => $empleo
            ]);
            return;
        }
        else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se pudo aplicar al empleo',
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

    public function buscarEmpleos($idUsuario, $buscar) {
    
        $empleos = $this->alumnoDao->getBusquedaEmpleo($idUsuario, $buscar);
        if ($empleos) {
            return [
                "success" => true,
                "body" => $empleos
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error: No se encontraron empleos',
            ];
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

    public function listarSuscripciones($idUsuario) {
        $suscripciones = $this->alumnoDao->getSuscripciones($idUsuario);
        if($suscripciones){
            
            $response = [
                "success" => true,
                "body" => $suscripciones
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

    public function obtenerNotificaciones($idUsuario) {
        $notificaciones = $this->alumnoDao->obtenerNotificaciones($idUsuario);
    
        if (!empty($notificaciones)) {
            return [
                "success" => true,
                "body" => $notificaciones
            ];
        } else {
            return [
                "success" => false,
                "message" => "No se encontraron notificaciones"
            ];
        }
    }

    public function eliminarSuscripcion() {
        
        $input = json_decode(file_get_contents('php://input'), true);
    
        $eventoId = $input['id'];
       
        $idUsuario = $_SESSION['user']['user_id'];

       // $descripcionNotificacion = "El evento '$nombreEvento' se ha eliminado.";

       $result = $this->alumnoDao->eliminarSuscripcion($eventoId,$idUsuario);
        
        // Devolvemos una respuesta JSON
        echo json_encode(['success' => $result]);
        exit();
        
    }

    public function agregarSuscripcion() {
        
        $input = json_decode(file_get_contents('php://input'), true);
    
        $eventoId = $input['id'];
       
        $idUsuario = $_SESSION['user']['user_id'];

       // $descripcionNotificacion = "El evento '$nombreEvento' se ha suscrito.";
       $result = $this->alumnoDao->agregarSuscripcion($idUsuario, $eventoId);
       
        
        echo json_encode(['success' => $result]);
        exit();
        
    }

    
    
    
}
?>


