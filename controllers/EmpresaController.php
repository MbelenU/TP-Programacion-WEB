<?php
require_once __DIR__ . '/../dal/UsuarioDAO.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../dal/EmpresaDAO.php';
require_once __DIR__ . '/../frontend/includes/base-url.php';
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
    
}elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['editarEmpleo'])) {
    $resultado = $empresaController->editarEmpleo($_GET['editarEmpleo']);
    return $resultado;
    exit;
}
elseif($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_carrera'])) {
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
elseif (isset($_GET['buscarAlumnos'])) {
    $query = $_GET['buscarAlumnos'];
    $resultados = $empresaController->buscarAlumnos($query);
    exit();
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['reclutarAlumno'])) {
    $resultados = $empresaController->reclutarAlumno();
    exit();
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['borrarPublicacion'])) {
    $resultados = $empresaController->borrarPublicacion();
    exit();
}

class EmpresaController {
    private EmpresaDAO $empresaDAO;
    public function __construct() {
        $this->empresaDAO = new EmpresaDAO();
    }
    public function listarAlumnos(){
        $alumnos = $this->empresaDAO->listarAlumnos();
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
    public function borrarPublicacion(){
        $input = json_decode(file_get_contents('php://input'), true);
        $result = $this->empresaDAO->borrarPublicacion($input['id']);     
        if($result){
            echo json_encode([
                "success" => true,
                "body" => $result
            ]);
        }
        else {
            echo json_encode([
                'success' => false,
                'message' => 'Error: No se pudo borrar la publicacion',
            ]);
        }
    }  
    
    public function getHabilidades(){
        $result = $this->empresaDAO->getHabilidades();
        if($result){
            return [
                "success" => true,
                "body" => $result
            ];
        }
        else {
            return [
                'success' => false,
                'message' => 'Error: No se pudo obtener habilidades',
            ];
        }
    }
    

    public function editarPerfilEmpresa($id) {
        $email = htmlspecialchars($_POST['email'] ?? ''); 
        $nombreEmpresa = htmlspecialchars($_POST['nombreEmpresa'] ?? ''); 
        $telefono = htmlspecialchars($_POST['phone'] ?? '');
        $descripcion = htmlspecialchars($_POST['descripcion'] ?? '');
        $sitio_web = htmlspecialchars($_POST['website'] ?? '');

        if (empty($email) || empty($descripcion) || empty($telefono) || empty($nombreEmpresa) || empty($sitio_web)) {
          
          return [
                'success' => false,
                'message' => 'Faltan datos obligatorios.'
            ];
            
        }


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
    
    public function editarEmpleo($idEmpleo){
        session_start();
        $idUsuario = $_SESSION['user']['user_id'];
        $input = json_decode(file_get_contents('php://input'), true);
        $idEmpleo = htmlspecialchars($idEmpleo ?? '');
        $titulo = htmlspecialchars($input['titulo'] ?? '');
        $modalidad = htmlspecialchars($input['modalidad'] ?? '');
        $ubicacion = htmlspecialchars($input['ubicacion'] ?? '');
        $jornada = htmlspecialchars($input['jornada'] ?? '');
        $descripcion = htmlspecialchars($input['descripcion'] ?? '');
        //$habilidad = $input['habilidades'] ?? '';
        //$materia = $input['materias'] ?? '';

        if (empty($idUsuario) ||empty($idUsuario) || empty($titulo) || empty($modalidad) || empty($ubicacion) || empty($jornada) || empty($descripcion)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Error: Faltan atributos',
            ]);
            return;
        } 
        
        $result = $this->empresaDAO->editarEmpleo($idEmpleo, $titulo, $modalidad, $ubicacion, $jornada, $descripcion, $idUsuario);
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
                "error" => "Error no se pudo editar el empleo"
            ]);
            return;
        }
    }
    public function publicarEmpleo(){
        session_start();
        $idUsuario = $_SESSION['user']['user_id'];
        $input = json_decode(file_get_contents('php://input'), true);

        $titulo = htmlspecialchars($input['titulo'] ?? '');
        $modalidad = htmlspecialchars($input['modalidad'] ?? '');
        $ubicacion = htmlspecialchars($input['ubicacion'] ?? '');
        $jornada = htmlspecialchars($input['jornada'] ?? '');
        $descripcion = htmlspecialchars($input['descripcion'] ?? '');
        $habilidad = $input['habilidades'] ?? '';
        $materia = $input['materias'] ?? '';

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
    public function buscarAlumnos($query){
        $busqueda = $this->empresaDAO->buscarAlumnos($query);
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
    
        if ($result) {
            $publicacion = $this->empresaDAO->obtenerPublicacionPorPostulacion($input['postulacion_id']);
            if (!$publicacion) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error: No se encontró la publicación de empleo',
                ]);
                return;
            }

            $alumnos = $this->empresaDAO->obtenerAlumnosPorPostulacion($input['postulacion_id']);
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
                    $this->empresaDAO->agregarNotificacion($alumno['id'], $descripcionNotificacion);
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
    
    public function reclutarAlumno() {
        // Decodificar la entrada JSON
        $input = json_decode(file_get_contents('php://input'), true);               
        $usuarioId = htmlspecialchars($input['usuario_id'] ?? ''); 
        $publicacionId = htmlspecialchars($input['publicacion_id'] ?? ''); 
        $estadoId = 3;
        //$idUsuario = htmlspecialchars($input['usuario_id'] ?? ''); Lo comento porque está repetido
   
        if (empty($publicacionId) || empty($usuarioId) ) { 
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Faltan datos obligatorios.'
            ]);
            return;
        }

    
        // Llamada al DAO para reclutar al alumno
        $result = $this->empresaDAO->reclutarAlumno($usuarioId, $publicacionId, $estadoId);
    
        // Comprobar si el resultado fue exitoso (verificamos la clave 'success' en el array)
        if ($result['success']) {
            // Obtener la publicación para enviar notificación
            $publicacion = $this->empresaDAO->obtenerPublicacion($publicacionId);
    
            if (!$publicacion) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error: No se encontró la publicación de empleo',
                ]);
                return;
            }
    
            // Descripción de la notificación que se enviará al usuario
            $descripcionNotificacion = "Fuiste reclutado para el puesto '{$publicacion->getTitulo()}'."; 
            
            $this->empresaDAO->agregarNotificacion($usuarioId, $descripcionNotificacion); //Cambié idUsuario por usuarioId
    
            // Responder con éxito
            http_response_code(200); 
            echo json_encode([
                'success' => true,
                'message' => 'El alumno ha sido reclutado con éxito.'
            ]);
        } else {
            // Si la respuesta del DAO fue que no se pudo reclutar
            http_response_code(500); 
            echo json_encode([
                'success' => false,
                'message' => $result['message'] // Usamos el mensaje del DAO
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
        $id = htmlspecialchars($_GET['idPlanEstudio'] ?? ''); 
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
        $id = htmlspecialchars($_GET['id_carrera'] ?? '');
        $planesEstudio = $this->empresaDAO->obtenerPlanesEstudio($id); //CAMBIO
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

    public function obtenerUsuarioPorId($id) {
        $usuario = $this->empresaDAO->obtenerUsuarioPorId($id);
        if($usuario){
            return [
                "success" => true,
                "body" => $usuario
            ];
        }
        else {
            return [
                'success' => false,
                'message' => 'Error: No se encontro usuario',
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
    public function obtenerHabilidad($id)
    {
        $habilidad = $this->empresaDAO->obtenerHabilidad($id);
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
