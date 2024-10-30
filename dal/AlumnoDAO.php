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
   
}

?>