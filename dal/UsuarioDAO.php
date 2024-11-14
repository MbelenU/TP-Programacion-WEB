<?php
require_once 'Database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Alumno.php';

class UsuarioDAO {

    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function iniciarSesion($email, $password) {
        $queryUser = "
            SELECT u.id as user_id, 
                   id_rol as user_type
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
            return $result;
        } 
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
    

}

?>