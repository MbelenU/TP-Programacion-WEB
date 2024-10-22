<?php
require_once __DIR__ . '/../dal/AlumnoDAO.php';
require_once __DIR__ . '/../models/Alumno.php';
require_once __DIR__ . '/../models/Usuario.php';

class AlumnoController {
    private AlumnoDAO $alumnoDao;

    public function __construct() {
        $this->alumnoDao = new AlumnoDAO();
    }

    
}
?>


