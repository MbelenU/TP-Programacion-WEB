<?php
require_once 'Database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Alumno.php';

class AlumnoDAO {

    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }
    public function editarPerfil(string $nombre, string $password, string $email, string $telefono, array $habilidades, Carrera $carrera, PlanEstudio $plan_estudio, array $materias, array $foto_perfil): ?Alumno {

    }
    public function iniciarSesion(string $email, string $password): ?Alumno {
        $queryUser = "SELECT * FROM usuario WHERE Mail = :email AND Clave = :password LIMIT 1";
    
        $stmtUser = $this->conn->prepare($queryUser);
        $stmtUser->bindParam(':email', $email);
        $stmtUser->bindParam(':password', $password);
        $stmtUser->execute();
    
        if ($stmtUser->rowCount() > 0) {
            $rowUser = $stmtUser->fetch(PDO::FETCH_ASSOC);

            $idUsuario = $rowUser['idUsuario'];
    
            $queryAlumno = "SELECT * FROM alumno WHERE FK_idUsuario = :idUsuario LIMIT 1";
            $stmtAlumno = $this->conn->prepare($queryAlumno);
            $stmtAlumno->bindParam(':idUsuario', $idUsuario);
            $stmtAlumno->execute();
    
            if ($stmtAlumno->rowCount() > 0) {
                $rowAlumno = $stmtAlumno->fetch(PDO::FETCH_ASSOC);
                // echo json_encode($rowAlumno);
                $alumno = new Alumno();
                $alumno->setNombre($rowAlumno['NombreAlumno']);
                $alumno->setApellidoAlumno($rowAlumno['ApellidoAlumno']);
                
                return $alumno;
            }
        }
    
        return null;
    }
}

?>