<?php
require_once __DIR__ . '/../dal/UsuarioDAO.php';
require_once __DIR__ . '/../models/Usuario.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$endpoint = $_GET['endpoint'] ?? '';

$usuarioController = new UsuarioController();

switch ($endpoint) {
    case "login":
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioController->iniciarSesion();
        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Método no permitido']);
        }
        break;
    case "register":
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $usuarioController->register();
            } else {
                http_response_code(405);
                echo json_encode(['message' => 'Método no permitido']);
            }
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint no encontrado']);
        break;
}

class UsuarioController {
    private UsuarioDAO $usuarioDao;

    public function __construct() {
        $this->usuarioDao = new UsuarioDAO();
    }

    public function iniciarSesion() {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $usuario = $this->usuarioDao->iniciarSesion($email, $password);

        if ($usuario) {
            echo json_encode([
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'usuario' => $usuario,
            ]);
        } else {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Credenciales incorrectas',
            ]);
        }
    }

    public function register() {
        $data = json_decode(file_get_contents('php://input'), true);
    
        $typeUser = $data['typeUser'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $repeatPassword = $data['repeatPassword'] ?? '';
        $direccion = $data['direccion'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $nombreUsuario = $data['nombreUsuario'] ?? '';
    
        if (empty($email) || empty($password) || empty($repeatPassword) || empty($nombreUsuario)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Faltan datos obligatorios.'
            ]);
            return;
        }
    
        if ($password !== $repeatPassword) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Las contraseñas no coinciden.'
            ]);
            return;
        }

        $respose = ['success' => false, 'message' => ''];
    
        if ($typeUser === 'alumno') {
            $nombre = $data['nombre'] ?? '';
            $apellido = $data['apellido'] ?? '';
            $dni = $data['dni'] ?? '';
    
            if (empty($nombre) || empty($apellido) || empty($dni)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Faltan datos obligatorios para el alumno.'
                ]);
                return;
            }

            $respose = $this->usuarioDao->registerAlumno($nombreUsuario, $password, $email, $telefono, $direccion, $nombre, $apellido, $dni);
    
        } else if ($typeUser === 'empresa') {
            $RazonSocial = $data['RazonSocial'] ?? '';
            $CUIT = $data['CUIT'] ?? '';
    
            if (empty($RazonSocial) || empty($CUIT)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Faltan datos obligatorios para la empresa.'
                ]);
                return;
            }
    
            $respose = $this->usuarioDao->registerEmpresa($nombreUsuario, $password, $email, $telefono, $direccion, $RazonSocial, $CUIT);
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
        } else {
            http_response_code(500);
            echo json_encode($respose);
        }
    }
    

}
