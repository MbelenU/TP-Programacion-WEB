<?php
require_once 'Database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Empresa.php';

class EmpresaDao {

    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }
   
}

?>