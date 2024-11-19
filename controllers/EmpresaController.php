<?php
require_once __DIR__ . '/../dal/UsuarioDAO.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../dal/EmpresaDAO.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
$empresaController = new EmpresaController();


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['publicarEmpleo'])) {
    $resultado = $empresaController->publicarEmpleo();
    return $resultado;
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_carrera'])) {
    $resultado = $empresaController->obtenerPlanesEstudio();
    return $resultado;
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['idPlanEstudio'])) {
    $resultado = $empresaController->obtenerMaterias();
    return $resultado;
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['habilidad'])) {
    $resultado = $empresaController->obtenerHabilidad($_GET['habilidad']);
    return $resultado;
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['cambiarEstadoPostulacion'])) {
    $resultado = $empresaController->cambiarEstadoPostulacion();
    return $resultado;
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['cambiarEstadoPublicacion'])) {
    $resultado = $empresaController->cambiarEstadoPublicacion();
    return $resultado;
    exit;
}

class EmpresaController {
    private EmpresaDAO $empresaDAO;
    public function __construct() {
        $this->empresaDAO = new EmpresaDAO();
    }
    public function editarPerfilEmpresa($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarPerfil'])) {
     
            $email = $_POST['email'];
            $nombreEmpresa = $_POST['nombreEmpresa'];
            $telefono = $_POST['phone'];
            $descripcion = $_POST['descripcion'];
            $sitio_web = $_POST['website'];
    
            $foto_perfil = null;
    
            if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] === UPLOAD_ERR_OK) {
                
                $fileTmpPath = $_FILES['fotoPerfil']['tmp_name'];
                $fileName = $_FILES['fotoPerfil']['name'];
                $newFileName = uniqid('profile_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                $uploadDir = 'img/';
                $uploadPath = $uploadDir . $newFileName;
        
               
                if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                    $foto_perfil = $newFileName;
                }
            } else {
                $foto_perfil = null; 
            }
            $result = $this->empresaDAO->editarPerfilEmpresa($id, $email, $nombreEmpresa, $telefono, $descripcion, $sitio_web, $foto_perfil);
    
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Perfil editado exitosamente',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al editar perfil',
                ];
            }
        }
    }
    
    public function publicarEmpleo(){
        session_start();
        $idUsuario = $_SESSION['user']['user_id'];
        $input = json_decode(file_get_contents('php://input'), true);

        $titulo = htmlspecialchars($input['titulo'] ?? null);
        $modalidad = htmlspecialchars($input['modalidad'] ?? null);
        $ubicacion = htmlspecialchars($input['ubicacion'] ?? null);
        $jornada = htmlspecialchars($input['jornada'] ?? null);
        $descripcion = htmlspecialchars($input['descripcion'] ?? null);
        $habilidad = htmlspecialchars($input['habilidad'] ?? null);
        $materia = htmlspecialchars($input['materia'] ?? null);

        if (empty($idUsuario) || empty($titulo) || empty($modalidad) || empty($ubicacion) || empty($jornada) || empty($descripcion)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Error: Faltan atributos',
            ]);
            return;
        } 
        
        $result = $this->empresaDAO->publicarEmpleo($titulo, $modalidad, $ubicacion, $jornada, $descripcion, $habilidad, $materia, $idUsuario);
        if($result) {
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "body" => $result
            ]);
            return;
        }else {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error" => "Error no se pudo publicar el empleo"
            ]);
            return;
        }

    }
    public function listarCarreras(){
        $carreras = $this->empresaDAO->listarCarreras();
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
    public function cambiarEstadoPostulacion() {
        $input = json_decode(file_get_contents('php://input'), true);
        $result = $this->empresaDAO->cambiarEstadoPostulacion($input['postulacion_id'], $input['estado_id']);
        if($result){
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "body" => $result
            ]);
            return;
        }
        else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se pudo cambiar el estado de la postulacion',
            ]);
        }
    }
    public function cambiarEstadoPublicacion() {
        $input = json_decode(file_get_contents('php://input'), true);
        $result = $this->empresaDAO->cambiarEstadoPublicacion($input['publicacion_id'], $input['estado_id']);
        if($result){
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "body" => $result
            ]);
            return;
        }
        else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se pudo cambiar el estado de la publicacion',
            ]);
        }
    }
    public function obtenerMaterias() {
        $id = $_GET['idPlanEstudio'];
        $materias = $this->empresaDAO->obtenerMaterias($id);
        if($materias){
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "body" => $materias
            ]);
            return;
        }
        else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se encontraron materias para este plan de estudios',
            ]);
        }
    }
    public function obtenerPlanesEstudio() {
        $id = $_GET['id_carrera'];
        $planesEstudio = $this->empresaDAO->obtenerPlanesEstudio($id);
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
    public function obtenerAlumno($id) {
        $alumno = $this->empresaDAO->obtenerAlumno($id);
        if($alumno){
            return [
                "success" => true,
                "body" => $alumno
            ];
        }
        else {
            return [
                'success' => false,
                'message' => 'Error: No se encontro alumno',
            ];
        }
    }
    public function listarJornadas(){
        $jornadas = $this->empresaDAO->listarJornadas();
        if($jornadas){
            return [
                "success" => true,
                "body" => $jornadas
            ];
        }
        else {
            return [
                'success' => false,
                'message' => 'Error: No se encontraron jornadas',
            ];
        }
    }
    public function listarModalidades(){
        $modalidades = $this->empresaDAO->listarModalidades();
        if($modalidades){
            return [
                "success" => true,
                "body" => $modalidades
            ];
        }
        else {
            return [
                'success' => false,
                'message' => 'Error: No se encontraron modalidades',
            ];
        }
    }
    public function obtenerHabilidad($nombreHabilidad)
    {
        $habilidad = $this->empresaDAO->obtenerHabilidad($nombreHabilidad);
        if ($habilidad) {
            echo json_encode([
                'success' => true,
                'body' => $habilidad
            ]);
            return;
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se encontro la habilidad',
            ]);
            return;
        }
    }
    public function obtenerPublicacion($idPublicacion)
    {
        $publicacion = $this->empresaDAO->obtenerPublicacion($idPublicacion);
        if($publicacion) {
            return [
                'success' => true,
                'body' => $publicacion
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error: No se encontro la publicacion',
            ];
        }
    }
    public function listarPublicaciones()
    {
        $idUsuario = $_SESSION['user']['user_id'];
        $publicaciones = $this->empresaDAO->listarPublicaciones($idUsuario);
        if($publicaciones) {
            return [
                'success' => true,
                'body' => $publicaciones
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error: No se encontraron publicaciones',
            ];
        }
    }
}
