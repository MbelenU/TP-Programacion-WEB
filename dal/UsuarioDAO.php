<?php
require_once 'Database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Alumno.php';
require_once __DIR__ . '/../models/PublicacionEmpleo.php';
class UsuarioDAO {

    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function iniciarSesion($email, $password) {
        $queryUser = "
            SELECT 
                u.id AS user_id, 
                id_rol AS user_type,
                u.de_baja
            FROM usuario u
            LEFT JOIN roles_usuario a ON u.id = a.id_usuario
            WHERE u.mail = :email AND u.clave = :password
            LIMIT 1;
        ";
        $stmtUser = $this->conn->prepare($queryUser);
        $stmtUser->bindParam(':email', $email);
        $stmtUser->bindParam(':password', $password);
        $stmtUser->execute();
    
        $result = $stmtUser->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            // Validar si el usuario está activo
            if ($result['de_baja'] === 'N') {
                // Usuario válido y activo
                return $result;
            } else {
                // Usuario deshabilitado
                return ['error' => 'Usuario deshabilitado. Contacte al administrador.'];
            }
        }
        // Usuario o contraseña incorrectos
        return null;
    }


    public function registerAlumno($nombreUsuario, $clave, $mail, $telefono, $direccion, $nombreAlumno, $apellidoAlumno, $dniAlumno) {
        try {
            $queryCheckUser = "
                SELECT COUNT(*) as count FROM usuario 
                WHERE mail = :mail OR nombre = :nombreUsuario
            ";
            
            $stmtCheckUser = $this->conn->prepare($queryCheckUser);
            $stmtCheckUser->bindParam(':mail', $mail);
            $stmtCheckUser->bindParam(':nombreUsuario', $nombreUsuario);
            $stmtCheckUser->execute();
            $userExists = $stmtCheckUser->fetch(PDO::FETCH_ASSOC)['count'];
    
            if ($userExists > 0) {
                return [
                    'success' => false,
                    'message' => 'El correo o nombre de usuario ya están en uso.'
                ];
            }
    
            $queryCheckDNI = "
                SELECT COUNT(*) as count FROM alumno 
                WHERE dni = :dniAlumno
            ";
            
            $stmtCheckDNI = $this->conn->prepare($queryCheckDNI);
            $stmtCheckDNI->bindParam(':dniAlumno', $dniAlumno);
            $stmtCheckDNI->execute();
            $dniExists = $stmtCheckDNI->fetch(PDO::FETCH_ASSOC)['count'];
    
            if ($dniExists > 0) {
                return [
                    'success' => false,
                    'message' => 'El DNI ya está registrado.'
                ];
            }
    
            $this->conn->beginTransaction();
    
            $queryUser = "
                INSERT INTO usuario (nombre, clave, mail, telefono, direccion) 
                VALUES (:nombreUsuario, :clave, :mail, :telefono, :direccion)
            ";
            
            $stmtUser = $this->conn->prepare($queryUser);
            $stmtUser->bindParam(':nombreUsuario', $nombreUsuario);
            $stmtUser->bindParam(':clave', $clave);
            $stmtUser->bindParam(':mail', $mail);
            $stmtUser->bindParam(':telefono', $telefono);
            $stmtUser->bindParam(':direccion', $direccion);
            $stmtUser->execute();
            
            $idUsuario = $this->conn->lastInsertId();
    
            $queryAlumno = "
                INSERT INTO alumno (id_usuario, nombre, apellido, dni) 
                VALUES (:idUsuario, :nombreAlumno, :apellidoAlumno, :dniAlumno)
            ";
            
            $stmtAlumno = $this->conn->prepare($queryAlumno);
            $stmtAlumno->bindParam(':idUsuario', $idUsuario);
            $stmtAlumno->bindParam(':nombreAlumno', $nombreAlumno);
            $stmtAlumno->bindParam(':apellidoAlumno', $apellidoAlumno);
            $stmtAlumno->bindParam(':dniAlumno', $dniAlumno);
            $stmtAlumno->execute();

            $queryRolesUsuario = "
                INSERT INTO roles_usuario (id_rol, id_usuario) 
                VALUES (2, :idUsuario)
            ";
            
            $stmtRolesUsuario = $this->conn->prepare($queryRolesUsuario);
            $stmtRolesUsuario->bindParam(':idUsuario', $idUsuario);
            $stmtRolesUsuario->execute();
    
            $this->conn->commit();

            return [
                'success' => true,
                'message' => 'Registro exitoso.'
            ];
    
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
    
    public function registerEmpresa($nombreUsuario, $clave, $email, $telefono, $direccion, $RazonSocial, $CUIT) {
        try {
            $queryCheckUser = "
                SELECT COUNT(*) as count FROM usuario 
                WHERE mail = :email OR nombre = :nombreUsuario
            ";
            
            $stmtCheckUser = $this->conn->prepare($queryCheckUser);
            $stmtCheckUser->bindParam(':email', $email);
            $stmtCheckUser->bindParam(':nombreUsuario', $nombreUsuario);
            $stmtCheckUser->execute();
            $userExists = $stmtCheckUser->fetch(PDO::FETCH_ASSOC)['count'];
    
            if ($userExists > 0) {
                return [
                    'success' => false,
                    'message' => 'El correo o nombre de usuario ya están en uso.'
                ];
            }

            $queryCheckCUIT = "
                SELECT COUNT(*) as count FROM empresas 
                WHERE cuit = :CUIT
            ";
            
            $stmtCheckCUIT = $this->conn->prepare($queryCheckCUIT);
            $stmtCheckCUIT->bindParam(':CUIT', $CUIT);
            $stmtCheckCUIT->execute();
            $cuitExists = $stmtCheckCUIT->fetch(PDO::FETCH_ASSOC)['count'];
    
            if ($cuitExists > 0) {
                return [
                    'success' => false,
                    'message' => 'El CUIT ya está registrado.'
                ];
            }
    
            $this->conn->beginTransaction();
    
            $queryUser = "
                INSERT INTO usuario (nombre, clave, mail, telefono, direccion) 
                VALUES (:nombreUsuario, :clave, :email, :telefono, :direccion)
            ";
            
            $stmtUser = $this->conn->prepare($queryUser);
            $stmtUser->bindParam(':nombreUsuario', $nombreUsuario);
            $stmtUser->bindParam(':clave', $clave);
            $stmtUser->bindParam(':email', $email);
            $stmtUser->bindParam(':telefono', $telefono);
            $stmtUser->bindParam(':direccion', $direccion);
            $stmtUser->execute();
            
            $idUsuario = $this->conn->lastInsertId();
    
            $queryEmpresa = "
                INSERT INTO empresas (id_usuario, razon_social, cuit) 
                VALUES (:idUsuario, :RazonSocial, :CUIT)
            ";
            
            $stmtEmpresa = $this->conn->prepare($queryEmpresa);
            $stmtEmpresa->bindParam(':idUsuario', $idUsuario);
            $stmtEmpresa->bindParam(':RazonSocial', $RazonSocial);
            $stmtEmpresa->bindParam(':CUIT', $CUIT);
            $stmtEmpresa->execute();

            $queryRolesUsuario = "
                INSERT INTO roles_usuario (id_rol, id_usuario) 
                VALUES (3, :idUsuario)
            ";
            
            $stmtRolesUsuario = $this->conn->prepare($queryRolesUsuario);
            $stmtRolesUsuario->bindParam(':idUsuario', $idUsuario);
            $stmtRolesUsuario->execute();
    
            $this->conn->commit();
    
            return [
                'success' => true,
                'message' => 'Registro exitoso.'
            ];
    
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
    public function listarAlumnos() {
        $queryAlumnos = "SELECT a.id, a.nombre, a.apellido, a.descripcion, u.foto_perfil FROM alumno a JOIN usuario u ON a.id_usuario = u.id";
        $stmt = $this->conn->prepare($queryAlumnos);
        $stmt->execute();
        
        $alumnosArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($alumnosArray) > 0) {
            $alumnos = [];
            foreach ($alumnosArray as $alumno) {
                $alumnoOBJ = new Alumno();
                $alumnoOBJ->setId($alumno['id']);
                $alumnoOBJ->setNombreAlumno($alumno['nombre']);
                $alumnoOBJ->setApellidoAlumno($alumno['apellido']);
                $alumnoOBJ->setDescripcion($alumno['descripcion'] ? $alumno['descripcion'] : '');
                $alumnoOBJ->setFotoPerfil($alumno['foto_perfil'] ? $alumno['foto_perfil'] : '');
                $alumnos[] = $alumnoOBJ;
            }
            return $alumnos;
        } else {
            return null;
        }
    }
    public function listarPublicaciones($idUsuario) {
        $queryPublicaciones = "SELECT * FROM publicaciones_empleos WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($queryPublicaciones);
        $stmt->bindParam(":id", $idUsuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $publicacionesArray = [];
            foreach($publicaciones as $publicacion){
                $publicacionOBJ = new PublicacionEmpleo();
                $fechaPostulacion = DateTime::createFromFormat('Y-m-d', $publicacion['fecha']);
                $publicacionOBJ->setId($publicacion['id']);
                $publicacionOBJ->setTitulo($publicacion['puesto_ofrecido']);
                $publicacionOBJ->setDescripcion($publicacion['descripcion']);
                $publicacionOBJ->setUbicacion($publicacion['ubicacion']);
                $publicacionOBJ->setFecha($fechaPostulacion);
                $publicacionesArray[] = $publicacionOBJ;
            }
            if($publicacionesArray){
                return $publicacionesArray;
            }
        }
        return null;
    }
    public function obtenerEmpresa($idUsuario){
        $queryEmpresa = "SELECT e.*, u.nombre, u.mail, u.telefono, u.direccion, u.foto_perfil 
                         FROM empresas e
                         INNER JOIN usuario u ON e.id_usuario = u.id
                         WHERE e.id_usuario = :id";
        
        $stmt = $this->conn->prepare($queryEmpresa);
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $empresa = new Empresa();
    
            $empresa->setId($row['id']);
            $empresa->setTelefono($row['telefono'] ? $row['telefono'] : '');  
            $empresa->setNombreEmpresa($row['razon_social'] ? $row['razon_social'] : '');  
            $empresa->setUbicacion($row['direccion'] ? $row['direccion'] : ''); 
            $empresa->setNombre($row['nombre'] ? $row['nombre'] : '');  
            $empresa->setSitioWeb($row['sitio_web'] ? $row['sitio_web'] : ''); 
            $empresa->setMailCorporativo($row['mail_corporativo'] ? $row['mail_corporativo'] : '');  
            $empresa->setFotoPerfil($row['foto_perfil'] ? $row['foto_perfil'] : '');
            $empresa->setDescripcion($row['descripcion'] ? $row['descripcion'] : '');  
    
            $empleos = $this->listarPublicaciones($idUsuario);
            $empresa->setEmpleosPublicados($empleos ? $empleos : []);
            return $empresa;
        }
    
        return null;
    }
    
    public function buscarPorEmail($email) {
        $query = "SELECT * FROM usuario WHERE mail = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function actualizarClave($idUsuario, $nuevaClave) {
        $query = "UPDATE usuario SET clave = :nuevaClave WHERE id = :idUsuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nuevaClave', $nuevaClave);
        $stmt->bindParam(':idUsuario', $idUsuario);
        return $stmt->execute();
    }
   
}

?>