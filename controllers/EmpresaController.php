<?php
require_once __DIR__ . '/../dal/UsuarioDAO.php';
require_once __DIR__ . '/../models/Usuario.php';

class EmpresaC {
    private UsuarioDAO $usuarioDao;

    public function __construct() {
        $this->usuarioDao = new UsuarioDAO();
    }
    public function register() {
        $error = '';
        $typeUser = htmlspecialchars($_POST['tipoUsuario'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $password = htmlspecialchars($_POST['password'] ?? '');
        $repeatPassword = htmlspecialchars($_POST['repeatPassword'] ?? '');
        $direccion = htmlspecialchars($_POST['direccion'] ?? '');
        $telefono = htmlspecialchars($_POST['telefono'] ?? '');
        $nombreUsuario = htmlspecialchars($_POST['nombreUsuario'] ?? '');

        if (empty($email) || empty($password) || empty($repeatPassword) || empty($nombreUsuario)) {
            $error = [
                'success' => false,
                'message' => 'Faltan datos obligatorios.'
            ];
            return $error;
        }
        if ($password !== $repeatPassword) {
            $error = [
                'success' => false,
                'message' => 'Las contraseñas no coinciden.'
            ];
            return $error;
        }
    
        if ($typeUser === 'alumno') {
            
            $nombre = htmlspecialchars($_POST['nombre'] ?? '');
            $apellido = htmlspecialchars($_POST['apellido'] ?? '');
            $dni = htmlspecialchars($_POST['dni'] ?? '');
    
            if (empty($nombre) || empty($apellido) || empty($dni)) {

                $error = [
                    'success' => false,
                    'message' => 'Faltan datos obligatorios para el alumno.'
                ];
                return $error;
            }

            $respose = $this->usuarioDao->registerAlumno($nombreUsuario, $password, $email, $telefono, $direccion, $nombre, $apellido, $dni);
    
        } else if ($typeUser === 'empresa') {
            $RazonSocial = $data['RazonSocial'] ?? '';
            $CUIT = $data['CUIT'] ?? '';
    
            if (empty($RazonSocial) || empty($CUIT)) {

                $error = [
                    'success' => false,
                    'message' => 'Faltan datos obligatorios para la empresa.'
                ];
                return $error;
            }
    
            $respose = $this->usuarioDao->registerEmpresa($nombreUsuario, $password, $email, $telefono, $direccion, $RazonSocial, $CUIT);
        } else {
            $error = [
                'success' => false,
                'message' => 'Tipo de usuario no válido.'
            ];
            return $error;
        }
        if ($respose['success']) {
            return $respose;
        } else {
            $error = $respose;
            return $error;
        }
    }
    

}

