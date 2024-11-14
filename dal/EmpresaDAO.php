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
require_once __DIR__ . '/../models/PublicacionEmpleo.php';
require_once __DIR__ . '/../models/Postulacion.php';




class EmpresaDAO {
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }
    public function obtenerPublicacion($idPublicacion){
        $queryPublicacion = "SELECT * FROM publicacionempleo where idPublicacionEmpleo = :id";
        $stmt = $this->conn->prepare($queryPublicacion);
        $stmt->bindParam(':id', $idPublicacion);
        $stmt->execute();
        if($stmt->rowCount()>0){
            $publicacion = $stmt->fetch(PDO::FETCH_ASSOC);
            $queryPostulacion = "SELECT * FROM postulacion WHERE FK_idPublicacionEmpleo = :id";
            $stmt = $this->conn->prepare($queryPostulacion);
            $stmt->bindParam(':id', $idPublicacion);
            $stmt->execute();
            $postulaciones = [];
            if($stmt->rowCount() > 0){
                $postulacionesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($postulacionesArray as $postulacion){
                    $postulacionObj = new Postulacion($postulacion['id'], $postulacion['fechaPostulacion'], $postulacion['estadoPostulacion'], $postulacion['postulante']);
                    $postulaciones[] = $postulacionObj;
                }
            }
            $publicacionObj = new PublicacionEmpleo();
            $publicacionObj->setId($publicacion['idPublicacionEmpleo']);
            $publicacionObj->setTitulo($publicacion['PuestoOfrecido']);
            $publicacionObj->setDescripcion($publicacion['DescripcionPuesto']);
            $publicacionObj->setPostulacion($postulaciones);
            return $publicacionObj->toArray();
        }
        return null;
    }
    public function publicarEmpleo($titulo, $modalidad, $ubicacion, $jornada, $descripcion, $habilidades, $materias, $idUsuario) {

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $date = date('Y-m-d H:i:s');
        $estadoPublicacion = 1;
        $queryEmpleo = "
            INSERT INTO publicacionempleo (PuestoOfrecido, DescripcionPuesto, FechaPublicacion, Ubicacion, usuarioId, FK_idEstadoPublicacion, FK_idJornada, FK_idModalidad)
            VALUES (:titulo, :descripcion, :date, :ubicacion, :idUsuario, :estadoPublicacion, :jornada, :modalidad)
        ";
        $stmt = $this->conn->prepare($queryEmpleo);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':estadoPublicacion', $estadoPublicacion);
        $stmt->bindParam(':jornada', $jornada);
        $stmt->bindParam(':modalidad', $modalidad);
        $stmt->execute();
        if($stmt->rowCount()>0){
            $empleoId = $this->conn->lastInsertId();
            if($habilidades) {
                foreach($habilidades as $habilidad) {
                    $queryHabilidades = "INSERT INTO habilidadxpublicacion (FK_idHabilidad, FK_idPublicacion) VALUES (:habilidad, :empleoId)";
                    $stmt = $this->conn->prepare($queryHabilidades);
                    $stmt->bindParam(':habilidad', $habilidad);
                    $stmt->bindParam(':empleoId', $empleoId);
                    $stmt->execute();
                }
            }
            if($materias){
                foreach($materias as $materia) {
                    $queryMaterias = "INSERT INTO materiasrequeridas (FK_idMateria, FK_PublicacionEmpleo) VALUES (:materia, :empleoId)";
                    $stmt = $this->conn->prepare($queryMaterias);
                    $stmt->bindParam(':materia', $materia);
                    $stmt->bindParam(':empleoId', $empleoId);
                    $stmt->execute();
                }
            }
            return $empleoId;
        }else {
            return null;
        }
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
    
}