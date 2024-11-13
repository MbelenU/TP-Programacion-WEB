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
            SELECT u.idUsuario as user_id, 
                   CASE 
                       WHEN a.idAlumno IS NOT NULL THEN 'Alumno'
                       WHEN e.idEmpresa IS NOT NULL THEN 'Empresa'
                       WHEN ad.idAdministradorUniversidad IS NOT NULL THEN 'Administrador'
                       ELSE NULL
                   END as user_type
            FROM usuario u
            LEFT JOIN alumno a ON u.idUsuario = a.FK_idUsuario
            LEFT JOIN empresa e ON u.idUsuario = e.FK_idUsuario
            LEFT JOIN administradoruniversidad ad ON u.idUsuario = ad.FK_idUsuario
            WHERE u.Mail = :email AND u.Clave = :password
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
                WHERE Mail = :mail OR NombreUsuario = :nombreUsuario
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
                WHERE DNI_Alumno = :dniAlumno
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
                INSERT INTO usuario (NombreUsuario, Clave, Mail, Telefono, Direccion) 
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
                INSERT INTO alumno (FK_idUsuario, NombreAlumno, ApellidoAlumno, DNI_Alumno) 
                VALUES (:idUsuario, :nombreAlumno, :apellidoAlumno, :dniAlumno)
            ";
            
            $stmtAlumno = $this->conn->prepare($queryAlumno);
            $stmtAlumno->bindParam(':idUsuario', $idUsuario);
            $stmtAlumno->bindParam(':nombreAlumno', $nombreAlumno);
            $stmtAlumno->bindParam(':apellidoAlumno', $apellidoAlumno);
            $stmtAlumno->bindParam(':dniAlumno', $dniAlumno);
            $stmtAlumno->execute();
    
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
                WHERE Mail = :email OR NombreUsuario = :nombreUsuario
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
                SELECT COUNT(*) as count FROM empresa 
                WHERE CUIT = :CUIT
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
                INSERT INTO usuario (NombreUsuario, Clave, Mail, Telefono, Direccion) 
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
                INSERT INTO empresa (FK_idUsuario, RazonSocial, CUIT) 
                VALUES (:idUsuario, :RazonSocial, :CUIT)
            ";
            
            $stmtEmpresa = $this->conn->prepare($queryEmpresa);
            $stmtEmpresa->bindParam(':idUsuario', $idUsuario);
            $stmtEmpresa->bindParam(':RazonSocial', $RazonSocial);
            $stmtEmpresa->bindParam(':CUIT', $CUIT);
            $stmtEmpresa->execute();
    
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