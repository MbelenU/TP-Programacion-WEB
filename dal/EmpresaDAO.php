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
require_once __DIR__ . '/../models/EstadoPostulacion.php';
require_once __DIR__ . '/../models/Alumno.php';



class EmpresaDAO {
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }
    public function listarPostulaciones($idPublicacion) {
        $queryPostulacion = "SELECT * FROM postulaciones WHERE id_publicacionesempleos = :id";
        $stmt = $this->conn->prepare($queryPostulacion);
        $stmt->bindParam(':id', $idPublicacion);
        $stmt->execute();
        $postulaciones = [];
        if ($stmt->rowCount() > 0) {
            $postulacionesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($postulacionesArray as $postulacion) {
                $fechaPostulacion = DateTime::createFromFormat('Y-m-d', $postulacion['fecha']);
                
                $estadoPostulacion = $this->obtenerEstadoPostulacion($postulacion['id_estadopublicacion']);
                
                $postulante = $this->obtenerPostulante($postulacion['id_usuario']);
                
                $postulacionObj = new Postulacion(
                    $postulacion['id'], 
                    $fechaPostulacion, 
                    $estadoPostulacion, 
                    $postulante
                );
                
                $postulaciones[] = $postulacionObj;
            }
        }
        return $postulaciones;
    }
    public function obtenerPostulante($idUsuario) {
        $query = "SELECT id, nombre, apellido FROM alumno WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $postulante = new Alumno();
            $postulante->setId($row['id']);
            $postulante->setNombreAlumno($row['nombre']);
            $postulante->setApellidoAlumno($row['apellido']);
            
            return $postulante;
        } else {
            return null;
        }
    }
    public function obtenerEstadoPostulacion($id_estadopublicacion) {
        $query = "SELECT * FROM estados_postulacion WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_estadopublicacion, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $estadoPostulacion = new EstadoPostulacion();
            $estadoPostulacion->setId($row['id']);
            $estadoPostulacion->setEstado($row['nombre']);
            
            return $estadoPostulacion;
        } else {
            return null;
        }
    }
    public function obtenerPublicacion($idPublicacion) {
        $queryPublicacion = "SELECT * FROM publicaciones_empleos WHERE id = :id";
        $stmt = $this->conn->prepare($queryPublicacion);
        $stmt->bindParam(':id', $idPublicacion);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $publicacion = $stmt->fetch(PDO::FETCH_ASSOC);
            $postulaciones = $this->listarPostulaciones($idPublicacion);
            $publicacionObj = new PublicacionEmpleo();
            $publicacionObj->setId($publicacion['id']);
            $publicacionObj->setTitulo($publicacion['puesto_ofrecido']);
            $publicacionObj->setDescripcion($publicacion['descripcion']);
            $publicacionObj->setPostulacion($postulaciones);
            return $publicacionObj;
        }
        return null;
    }
    public function publicarEmpleo($titulo, $modalidad, $ubicacion, $jornada, $descripcion, $habilidades, $materias, $idUsuario) {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $date = date('Y-m-d H:i:s');
        $estadoPublicacion = 1;
        $queryEmpleo = "
            INSERT INTO publicaciones_empleos (puesto_ofrecido, descripcion, fecha, ubicacion, id_usuario, id_estadopublicacion, id_jornada, id_modalidad)
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
        if($stmt->rowCount() > 0){
            $empleoId = $this->conn->lastInsertId();
            if($habilidades) {
                foreach($habilidades as $habilidad) {
                    $queryHabilidades = "INSERT INTO habilidades_publicaciones (id_habilidad, id_publicacion) VALUES (:habilidad, :empleoId)";
                    $stmt = $this->conn->prepare($queryHabilidades);
                    $stmt->bindParam(':habilidad', $habilidad);
                    $stmt->bindParam(':empleoId', $empleoId);
                    $stmt->execute();
                }
            }
            if($materias){
                foreach($materias as $materia) {
                    $queryMaterias = "INSERT INTO materias_requeridas (id_materia, id_publicacionesempleos) VALUES (:materia, :empleoId)";
                    $stmt = $this->conn->prepare($queryMaterias);
                    $stmt->bindParam(':materia', $materia);
                    $stmt->bindParam(':empleoId', $empleoId);
                    $stmt->execute();
                }
            }
            return $empleoId;
        } else {
            return null;
        }
    }
    public function listarCarreras() {
        $queryCarreras = "SELECT * FROM carreras";
        $stmt = $this->conn->prepare($queryCarreras);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $carrerasArray = [];
            foreach($carreras as $carrera){
                $id = $carrera['id'];
                $nombreCarrera = $carrera['nombre_carrera'];
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
    public function obtenerHabilidad($nombreHabilidad) {
        $query = "SELECT * FROM habilidades WHERE descripcion = :nombreHabilidad";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombreHabilidad', $nombreHabilidad);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $habilidad = new Habilidad();
            $habilidad->setId($row['id']);
            $habilidad->setNombreHabilidad($row['descripcion']);
            $habilidad = $habilidad->toArray();
            return $habilidad;
        }
        return null;
    }
    public function obtenerMaterias($idPlanEstudio) {
        $queryMaterias = "
            SELECT 
                m.id, 
                m.nombre, 
                m.detalle
            FROM 
                materias m
            JOIN 
                planes_materias pm ON m.id = pm.id_materia
            WHERE 
                pm.id_planestudio = :idPlanEstudio;
        ";
        $stmt = $this->conn->prepare($queryMaterias);
        $stmt->bindParam(':idPlanEstudio', $idPlanEstudio, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $materiasArray = [];
            foreach($materias as $materia){
                $id = $materia['id'];
                $nombreMateria = $materia['nombre'];
                $detalleMateria = $materia['detalle'];
                $materiaOBJ = new Materia($id, $nombreMateria, $detalleMateria);
                $materiasArray[] = $materiaOBJ->toArray();
            }
            if($materiasArray){
                return $materiasArray;
            }
        }
        return null;
    }
    public function obtenerPlanesEstudio($idCarrera) {
        $queryPlanes = "SELECT * FROM plan_estudio WHERE id_carrera = :idCarrera";
        $stmt = $this->conn->prepare($queryPlanes);
        $stmt->bindParam(':idCarrera', $idCarrera, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $planes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $planesArray = [];
            foreach($planes as $plan){
                $id = $plan['id'];
                $nombrePlan = $plan['nombre'];
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
        $queryJornadas = "SELECT * FROM jornadas";
        $stmt = $this->conn->prepare($queryJornadas);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $jornadas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $jornadasArray = [];
            foreach($jornadas as $jornada){
                $id = $jornada['id'];
                $descripcion = $jornada['descripcion'];
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
        $queryModalidades = "SELECT * FROM modalidades";
        $stmt = $this->conn->prepare($queryModalidades);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $modalidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $modalidadesArray = [];
            foreach($modalidades as $modalidad){
                $id = $modalidad['id'];
                $descripcion = $modalidad['descripcion'];
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