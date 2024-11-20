<?php
require_once 'Database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Administrador.php';

class AdministradorDAO
{

    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }
    public function getUsuarios() {
        $queryUsuarios = "SELECT id, nombre, mail, de_baja FROM usuario";
    
        try {
            $stmt = $this->conn->prepare($queryUsuarios);
            $stmt->execute();
    
            // Obtener los resultados como un arreglo asociativo
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $resultados;
        } catch (PDOException $e) {
            // Manejo de errores
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }
    public function updatePassword($userId, $newPassword) {
        $query = "UPDATE usuario SET clave = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        //$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT); // Encriptar contraseña
        return $stmt->execute([$newPassword, $userId]);
    }
    public function setUserStatus($userId, $status) {
        $query = "UPDATE usuario SET de_baja = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $userId]);
    }
    public function setUserStatushab($userId, $status) {
        $query = "UPDATE usuario SET de_baja = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $userId]);
    }

    public function registerAlumno($nombreUsuario, $clave, $mail, $nombreAlumno, $apellidoAlumno) {
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
    
            
    
            $this->conn->beginTransaction();
    
            $queryUser = "
                INSERT INTO usuario (nombre, clave, mail) 
                VALUES (:nombreUsuario, :clave, :mail)
            ";
            
            $stmtUser = $this->conn->prepare($queryUser);
            $stmtUser->bindParam(':nombreUsuario', $nombreUsuario);
            $stmtUser->bindParam(':clave', $clave);
            $stmtUser->bindParam(':mail', $mail);
           
            $stmtUser->execute();
            
            $idUsuario = $this->conn->lastInsertId();
    
            $queryAlumno = "
                INSERT INTO alumno (id_usuario, nombre, apellido) 
                VALUES (:idUsuario, :nombreAlumno, :apellidoAlumno)
            ";
            
            $stmtAlumno = $this->conn->prepare($queryAlumno);
            $stmtAlumno->bindParam(':idUsuario', $idUsuario);
            $stmtAlumno->bindParam(':nombreAlumno', $nombreAlumno);
            $stmtAlumno->bindParam(':apellidoAlumno', $apellidoAlumno);
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
    
    public function registerEmpresa($nombreUsuario, $clave, $email, $RazonSocial) {
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

    
            $this->conn->beginTransaction();
    
            $queryUser = "
                INSERT INTO usuario (nombre, clave, mail) 
                VALUES (:nombreUsuario, :clave, :email)
            ";
            
            $stmtUser = $this->conn->prepare($queryUser);
            $stmtUser->bindParam(':nombreUsuario', $nombreUsuario);
            $stmtUser->bindParam(':clave', $clave);
            $stmtUser->bindParam(':email', $email);
            
            $stmtUser->execute();
            
            $idUsuario = $this->conn->lastInsertId();
    
            $queryEmpresa = "
                INSERT INTO empresas (id_usuario, razon_social) 
                VALUES (:idUsuario, :RazonSocial)
            ";
            
            $stmtEmpresa = $this->conn->prepare($queryEmpresa);
            $stmtEmpresa->bindParam(':idUsuario', $idUsuario);
            $stmtEmpresa->bindParam(':RazonSocial', $RazonSocial);
            
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