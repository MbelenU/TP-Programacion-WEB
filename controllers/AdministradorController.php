<?php
require_once __DIR__ . '/../dal/AdministradorDAO.php';
require_once __DIR__ . '/../models/Usuario.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$endpoint = $_GET['endpoint'] ?? '';

$administradorController = new AdministradorController();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['publicarEmpleo'])) {
    $resultado = $administradorController->publicarEmpleo();
    return $resultado;
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_carrera'])) {
    $resultado = $administradorController->obtenerPlanesEstudio();
    return $resultado;
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['idPlanEstudio'])) {
    $resultado = $administradorController->obtenerMaterias();
    return $resultado;
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['habilidad'])) {
    $resultado = $administradorController->obtenerHabilidad($_GET['habilidad']);
    return $resultado;
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['cambiarEstadoPostulacion'])) {
    $resultado = $administradorController->cambiarEstadoPostulacion();
    return $resultado;
    exit;
}elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['cambiarEstadoPublicacion'])) {
    $resultado = $administradorController->cambiarEstadoPublicacion();
    return $resultado;
    exit;
}
elseif (isset($_GET['buscarAlumnos'])) {
    $query = $_GET['buscarAlumnos'];
    $resultados = $administradorController->buscarAlumnos($query);
    exit();
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['reclutarAlumno'])) {
    $resultados = $administradorController->reclutarAlumno();
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $endpoint === "register") {
    $administradorController = new AdministradorController();
    $resultado = $administradorController->register();
    return $resultado;
    exit;
}elseif(isset($_GET['action'])) {
    $administradorController = new AdministradorController();
    $administradorController->handleRequest();
}elseif(isset($_GET['buscarUsuarios'])) {
    $query = $_GET['buscarUsuarios'];
    $administradorController = new AdministradorController();
    $resultado = $administradorController->buscarUsuarios($query);
    return $resultado;
    exit; 
}elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['borrarEvento'])){
    $administradorController = new AdministradorController();
    $resultado = $administradorController->eliminarEvento();
    return $resultado;
    exit;
}



class AdministradorController 
{
    private AdministradorDAO $administradorDAO;

    public function __construct() {
        $this->administradorDAO = new AdministradorDAO();
    }


    public function crearEvento(){
        $titulo = $_POST['titulo'] ? $_POST['titulo'] : NULL;
        $fecha = $_POST['fecha'] ? $_POST['fecha'] : NULL ;
        $hora = $_POST['hora'] ? $_POST['hora'] : NULL;
        $tipo = $_POST['tipo'] ? $_POST['tipo'] : NULL;
        $descripcion = $_POST['descripcion'] ? $_POST['descripcion'] : NULL;
        $creditos = $_POST['creditos'] ? $_POST['creditos'] : NULL;
        

        $evento = $this->administradorDAO->crearEvento($_SESSION['user']['user_id'], $titulo, $tipo ,$fecha, $hora, $descripcion, $creditos);
        if($evento){
             $alumnos = $this->administradorDAO->obtenerAlumnos();

                    if ($alumnos) {
                        $descripcionNotificacion = "Se ha creado un nuevo evento: " . $titulo;

                        foreach ($alumnos as $alumno) {
                            $this->administradorDAO->agregarNotificacion($alumno['id'], $descripcionNotificacion);
                        }
                    }
            $response = [
                "success" => true,
                "body" => $evento
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

    public function obtenerEventoPorId($eventoId) {
        
        if (!is_numeric($eventoId) || $eventoId <= 0) {
            return [
                "status" => "error",
                "message" => "ID de evento inválido"
            ];
        }

        $evento = $this->administradorDAO->obtenerEventoPorId($eventoId);

        if ($evento) {
            return [
                "status" => "success",
                "body" => $evento
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Evento no encontrado"
            ];
        }
    }

    public function editarEvento($id){
        
        $titulo = $_POST['titulo'] ? $_POST['titulo'] : NULL;
        $fecha = $_POST['fecha'] ? $_POST['fecha'] : NULL ;
        $tipo = $_POST['tipo'] ? $_POST['tipo'] : NULL;
        $descripcion = $_POST['descripcion'] ? $_POST['descripcion'] : NULL;
        $creditos = $_POST['creditos'] ? $_POST['creditos'] : NULL;

        $check = $this->administradorDAO->editarEvento($id, $titulo, $fecha, $tipo, $descripcion, $creditos);
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
    
    // Método para obtener todos los usuarios
    public function listarUsuarios() {
        $usuarios = $this->administradorDAO->getUsuarios();
        if ($usuarios !== false) {
            return $usuarios;
        } else {
            return [];
        }
    }
    public function buscarUsuarios($query) {
        $result = $this->administradorDAO->buscarUsuarios($query);
        if($result){
            echo json_encode([
                "success" => true,
                "body" => $result
            ]);
        }
        else {
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se pudo obtener los usuarios',
            ]);
        }
    }
    
    public function cambiarClave($userId, $newPassword) {
        return $this->administradorDAO->updatePassword($userId, $newPassword);
    }
    public function darDeBaja($userId) {
        return $this->administradorDAO->setUserStatus($userId, 'S'); // 'S' para inactivo
    }
    public function habilitar($userId) {
        return $this->administradorDAO->setUserStatushab($userId, 'N'); // 'N' para activo
    }
    
    public function getEventos() {
        return $this->administradorDAO->getEventos();
    }
    public function getEventosDeAdmin() {
        return $this->administradorDAO->getEventos($_SESSION['user']['user_id']);
    }

    public function register() {
        
        $input = json_decode(file_get_contents('php://input'), true);
        $typeUser = htmlspecialchars($input['typeUser'] ?? '');
        $email = htmlspecialchars($input['email'] ?? '');
        $password = htmlspecialchars($input['password'] ?? '');
        $nombreUsuario = htmlspecialchars($input['nombreUsuario'] ?? '');

        if (empty($email) || empty($password)  || empty($nombreUsuario)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Faltan datos obligatorios.'
            ]);
            return;
        }
    

        if ($typeUser == 2) {
            $nombre = htmlspecialchars($input['nombre'] ?? '');
            $apellido = htmlspecialchars($input['apellido'] ?? '');
    
            if (empty($nombre) || empty($apellido)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Faltan datos obligatorios para el alumno.'
                ]);
                return;
            }

            $respose = $this->administradorDAO->registerAlumno($nombreUsuario, $password, $email, $nombre, $apellido);
    
        } else if ($typeUser == 3) {
            $RazonSocial = htmlspecialchars($input['RazonSocial'] ?? '');
            

            if (empty($RazonSocial)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Faltan datos obligatorios para la empresa.'
                ]);
                return;
            }
    
            $respose = $this->administradorDAO->registerEmpresa($nombreUsuario, $password, $email, $RazonSocial);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Tipo de usuario no válido.'
            ]);
            return;
        }
        if ($respose['success']) {
            echo json_encode($respose);
            return;
        } else {
            http_response_code(500);
            echo json_encode($respose);
            return;
        }
        
    }

    public function handleRequest()
    {
        $action = $_GET['action'] ?? null;
        $input =  json_decode(file_get_contents('php://input'), true);
        switch ($action) {
            case 'getAllHabilidades':
                $this->getAllHabilidades();
                break;
            case 'searchHabilidad':
                $this->searchHabilidad();
                break;
            case 'addHabilidad':
                $this->addHabilidad();
                break;
            case 'deleteHabilidad':
                $this->deleteHabilidad();
                break;
            case 'darDeBaja':
                $userId = $input['userId'] ?? null;
                if ($userId) {
                    $result = $this->darDeBaja($userId);
                    echo json_encode(['success' => $result]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID de usuario no proporcionado.']);
                }
                break;
            case 'habilitar':
                $userId = $input['userId'] ?? null;
                if ($userId) {
                    $result = $this->habilitar($userId);
                    echo json_encode(['success' => $result]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID de usuario no proporcionado.']);
                }
                break;
            case 'cambiarContrasena':
                $userId = $input['userId'] ?? null;
                $newPassword = $input['newPassword'] ?? null;
                if ($userId && $newPassword) {
                    $result = $this->cambiarClave($userId, $newPassword);
                    echo json_encode(['success' => $result]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Datos insuficientes para cambiar la contraseña.']);
                }
                break;
            default:
                echo json_encode(['error' => 'Acción no válida']);
        }
    }
    
    private function getAllHabilidades()
    {
        $administradorDAO = new AdministradorDAO();
        $habilidades = $administradorDAO->getAllHabilidades();
        echo json_encode($habilidades);
    }

    private function searchHabilidad()
    {
        $query = $_GET['query'] ?? '';
        $administradorDAO = new AdministradorDAO();
        $habilidades = $administradorDAO->searchHabilidad($query);
        echo json_encode($habilidades);
    }

    private function addHabilidad() {
        $data = json_decode(file_get_contents('php://input'), true);
        $descripcion = $data['descripcion'] ?? '';
    
        if (empty($descripcion)) {
            echo json_encode(['success' => false, 'message' => 'Descripción vacía']);
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
    
        $success = $this->administradorDAO->addHabilidad($descripcion);
        echo json_encode(['success' => $success]);
        return;
    }
/*
    private function addHabilidad()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $descripcion = $data['descripcion'] ?? '';
        $administradorDAO = new AdministradorDAO();
        $success = $administradorDAO->addHabilidad($descripcion);
        echo json_encode(['success' => $success]);
    }
*/
    private function deleteHabilidad()
    {
        $id = $_GET['id'] ?? 0;
        $administradorDAO = new AdministradorDAO();
        $success = $administradorDAO->deleteHabilidad($id);
        echo json_encode(['success' => $success]);
    }

    public function eliminarEvento() {
        
        $input = json_decode(file_get_contents('php://input'), true);
    
        $eventoId = $input['id'];
        $result = $this->administradorDAO->eliminarEvento($eventoId);

        $nombreEvento = $input['nombreEvento'];
        $alumnos = $this->administradorDAO->obtenerAlumnos();
        $descripcionNotificacion = "El evento '$nombreEvento' se ha eliminado.";

        foreach ($alumnos as $alumno) {
            $this->administradorDAO->agregarNotificacion($alumno['id'], $descripcionNotificacion);
        }
        
        // Devolvemos una respuesta JSON
        echo json_encode(['success' => $result]);
        exit();
        
    }

    public function listarAlumnos(){
        $alumnos = $this->administradorDAO->listarAlumnos();
        if($alumnos){
            return[
                "success" => true,
                "body" => $alumnos
            ];
        }
        else {
            return[
                'success' => false,
                'message' => 'Error: No se encontraron alumnos',
            ];
        }
    }  

    public function listarModalidades(){
        $modalidades = $this->administradorDAO->listarModalidades();
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

    public function listarJornadas(){
        $jornadas = $this->administradorDAO->listarJornadas();
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

    public function listarCarreras(){
        $carreras = $this->administradorDAO->listarCarreras();
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

    public function obtenerAlumno($id) {
        $alumno = $this->administradorDAO->obtenerAlumno($id);
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

    public function obtenerPlanesEstudio() {
        $id = $_GET['id_carrera'];
        $planesEstudio = $this->administradorDAO->obtenerPlanesEstudio($id);
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

    public function obtenerHabilidad($nombreHabilidad)
    {
        $habilidad = $this->administradorDAO->obtenerHabilidad($nombreHabilidad);
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

    public function listarPublicaciones()
    {
        $idUsuario = $_SESSION['user']['user_id'];
        $publicaciones = $this->administradorDAO->listarPublicaciones($idUsuario);
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

    public function obtenerPublicacion($idPublicacion)
    {
        $publicacion = $this->administradorDAO->obtenerPublicacion($idPublicacion);
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

    public function buscarAlumnos($query){
        $busqueda = $this->administradorDAO->buscarAlumnos($query);
        if($busqueda){
            echo json_encode([
                "success" => true,
                "body" => $busqueda
            ]);
            return;
        }
        else {
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se encontraron alumnos',
            ]);
            return;
        }
    }

    public function reclutarAlumno() {
        $input = json_decode(file_get_contents('php://input'), true);               
        $usuarioId = $input['usuario_id']; 
        $publicacionId = $input['publicacion_id']; 
        $estadoId = 3;
    
        $result = $this->administradorDAO->reclutarAlumno($usuarioId, $publicacionId, $estadoId);
    
        if ($result['success']) {
            $publicacion = $this->administradorDAO->obtenerPublicacion($publicacionId);
    
            if (!$publicacion) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error: No se encontró la publicación de empleo',
                ]);
                return;
            }
    
            $descripcionNotificacion = "Fuiste reclutado para el puesto '{$publicacion->getTitulo()}'."; 
            $idUsuario = $input['usuario_id']; 
            $this->administradorDAO->agregarNotificacion($idUsuario, $descripcionNotificacion);
    
            http_response_code(200); 
            echo json_encode([
                'success' => true,
                'message' => 'El alumno ha sido reclutado con éxito.'
            ]);
        } else {
            http_response_code(500); 
            echo json_encode([
                'success' => false,
                'message' => $result['message']
            ]);
        }
    }
    public function cambiarEstadoPostulacion() {
        $input = json_decode(file_get_contents('php://input'), true);
        $result = $this->administradorDAO->cambiarEstadoPostulacion($input['postulacion_id'], $input['estado_id']);
    
        if ($result) {
            $publicacion = $this->administradorDAO->obtenerPublicacionPorPostulacion($input['postulacion_id']);
            if (!$publicacion) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error: No se encontró la publicación de empleo',
                ]);
                return;
            }

            $alumnos = $this->administradorDAO->obtenerAlumnosPorPostulacion($input['postulacion_id']);
            if ($alumnos) {
                switch ($input['estado_id']) {
                    case 1:
                        $descripcionNotificacion = "Tu postulación para el puesto '{$publicacion['puesto_ofrecido']}' fue recibida.";
                        break;
                    case 2:
                        $descripcionNotificacion = "Tu postulación para el puesto '{$publicacion['puesto_ofrecido']}' está en evaluación.";
                        break;
                    case 3:
                        $descripcionNotificacion = "Fuiste reclutado para el puesto '{$publicacion['puesto_ofrecido']}'.";
                        break;
                    case 4:
                        $descripcionNotificacion = "Tu postulación para el puesto '{$publicacion['puesto_ofrecido']}' ha finalizado.";
                        break;
                    default:
                        $descripcionNotificacion = "El estado de tu postulación para el puesto '{$publicacion['puesto_ofrecido']}' ha cambiado.";
                }
    
                foreach ($alumnos as $alumno) {
                    $this->administradorDAO->agregarNotificacion($alumno['id'], $descripcionNotificacion);
                }
            }
    
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "body" => $result
            ]);
            return;
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se pudo cambiar el estado de la postulación',
            ]);
        }
    }

    public function cambiarEstadoPublicacion() {
        $input = json_decode(file_get_contents('php://input'), true);
        $result = $this->administradorDAO->cambiarEstadoPublicacion($input['publicacion_id'], $input['estado_id']);
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
        
        $result = $this->administradorDAO->publicarEmpleo($titulo, $modalidad, $ubicacion, $jornada, $descripcion, $habilidad, $materia, $idUsuario);
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

    public function obtenerNotificaciones($idUsuario) {
        $notificaciones = $this->administradorDAO->obtenerNotificaciones($idUsuario);
    
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

}





?>