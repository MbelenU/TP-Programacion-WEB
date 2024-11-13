<?php
require_once 'Database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../models/Modalidad.php';
require_once __DIR__ . '/../models/Jornada.php';
require_once __DIR__ . '/../models/Carrera.php';
require_once __DIR__ . '/../models/PlanEstudio.php';
require_once __DIR__ . '/../models/Materia.php';
require_once __DIR__ . '/../models/Habilidad.php';

class EmpresaDAO {
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }
    public function listarCarreras() {
        $queryCarreras = "SELECT * FROM carrera";
        $stmt = $this->conn->prepare($queryCarreras);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $carrerasArray = [];
            foreach($carreras as $carrera){
                $id = $carrera['idCarrera'];
                $nombreCarrera = $carrera['NombreCarrera'];
                $planEstudios = $this->obtenerPlanesEstudio($id);
                $carreraOBJ = new Carrera($id, $nombreCarrera, $planEstudios);
                $carrerasArray[] = $carreraOBJ->toArray();
            }
            if($carrerasArray){
                return $carrerasArray;
            }
        }
        return null;
    }
    public function obtenerHabilidad($nombreHabilidad)
    {
        $query = "SELECT * FROM habilidad WHERE Descripcion = :nombreHabilidad";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombreHabilidad', $nombreHabilidad);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $habilidad = new Habilidad();

            $habilidad->setId($row['idHabilidad']);
            $habilidad->setNombreHabilidad($row['Descripcion']);
            $habilidad = $habilidad->toArray();
            return $habilidad;
        }
        return null;
    }
    public function obtenerMaterias($idPlanEstudio) {
        $queryMaterias = "
            SELECT 
                m.idMateria, 
                m.NombreMateria, 
                m.DetalleMateria
            FROM 
                materia m
            JOIN 
                planxmateria pm ON m.idMateria = pm.FK_idMateria
            WHERE 
                pm.FK_idPlanCarrera = :idPlanEstudio;
        ";
        $stmt = $this->conn->prepare($queryMaterias);
        $stmt->bindParam(':idPlanEstudio', $idPlanEstudio, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $materiasArray = [];
            foreach($materias as $materia){
                $id = $materia['idMateria'];
                $nombreMateria = $materia['NombreMateria'];
                $DetalleMateria = $materia['DetalleMateria'];
                $materiaOBJ = new Materia($id, $nombreMateria, $DetalleMateria);
                $materiasArray[] = $materiaOBJ->toArray();
            }
            if($materiasArray){
                return $materiasArray;
            }
        }
        return null;
    }
    public function obtenerPlanesEstudio($idCarrera) {
        $queryPlanes = "SELECT * FROM planestudio WHERE FK_idCarrera = :idCarrera";
        $stmt = $this->conn->prepare($queryPlanes);
        $stmt->bindParam(':idCarrera', $idCarrera, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $planes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $planesArray = [];
            foreach($planes as $plan){
                $id = $plan['idPlanEstudio'];
                $nombrePlan = $plan['NombrePlanEstudio'];
                $planOBJ = new PlanEstudio($id, $nombrePlan);
                $planesArray[] = $planOBJ->toArray();
            }
            if($planesArray){
                return $planesArray;
            }
        }
        return null;
    }
    public function listarJornadas() {
        $queryJornadas = "SELECT * FROM jornada";
        $stmt = $this->conn->prepare($queryJornadas);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $jornadas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $jornadasArray = [];
            foreach($jornadas as $jornada){
                $id = $jornada['idJornada'];
                $descripcion = $jornada['DescripcionJornada'];
                $jornadaOBJ = new Jornada($id, $descripcion);
                $jornadasArray[] = $jornadaOBJ->toArray();
            }
            if($jornadasArray){
                return $jornadasArray;
            }
        }
        return null;
    }
    public function listarModalidades() {
        $queryModalidades = "SELECT * FROM modalidad";
        $stmt = $this->conn->prepare($queryModalidades);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $modalidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $modalidadesArray = [];
            foreach($modalidades as $modalidad){
                $id = $modalidad['idModalidad'];
                $descripcion = $modalidad['DescripcionModalidad'];
                $modalidadOBJ = new Modalidad($id, $descripcion);
                $modalidadesArray[] = $modalidadOBJ->toArray();
            }
            if($modalidadesArray){
                return $modalidadesArray;
            }
        }
        return null;
    }
    public function publicarEmpleo($titulo, $modalidad, $ubicacion, $jornada, $descripcion, $habilidad, $carrera, $plan_estudios, $materia) {
        $queryEmpleo = "
            INSERT INTO EMPLEO (Titulo, Modalidad, Ubicacion, Jornada, Descripcion, Habilidad, Carrera, Plan_Estudios, Materia)
            VALUES (:titulo, :modalidad, :ubicacion, :jornada, :descripcion, :habilidad, :carrera, :plan_estudios, :materia)
        ";
        $stmt = $this->conn->prepare($queryEmpleo);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindValue(':modalidad', $modalidad);
        $stmt->bindValue(':ubicacion', $ubicacion);
        $stmt->bindValue(':jornada', $jornada);
        $stmt->bindValue(':descripcion', $descripcion);
        $stmt->bindValue(':habilidad', $habilidad);
        $stmt->bindValue(':carrera', $carrera);
        $stmt->bindValue(':plan_estudios', $plan_estudios);
        $stmt->bindValue(':materia', $materia);
    
        $stmt->execute();
    }
}