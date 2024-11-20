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
require_once __DIR__ . '/../models/EstadoEmpleo.php';
require_once __DIR__ . '/../models/Alumno.php';



class EmpresaDAO {
    private PDO $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }
    public function editarPerfilEmpresa($id, $email, $nombreEmpresa, $telefono, $descripcion, $sitio_web, $foto_perfil)
    {
        try {


            $this->conn->beginTransaction();
   
            $queryEmpresa = "UPDATE empresas SET ";
            if ($nombreEmpresa !== null && $nombreEmpresa !== '') {
                $updateEmpresaFields[] = "razon_social = :nombreEmpresa";
                $paramsEmpresa[':nombreEmpresa'] = $nombreEmpresa;
            }
            if ($email !== null && $email !== '') {
                $updateEmpresaFields[] = "mail_corporativo = :email";
                $paramsEmpresa[':email'] = $email;
            }
            if ($descripcion !== null) {
                $updateEmpresaFields[] = "descripcion = :descripcion";
                $paramsEmpresa[':descripcion'] = $descripcion;
            }
            if ($sitio_web !== null) {
                $updateEmpresaFields[] = "sitio_web = :sitio_web";
                $paramsEmpresa[':sitio_web'] = $sitio_web;
            }
            if (count($updateEmpresaFields) > 0) {
                $queryEmpresa .= implode(", ", $updateEmpresaFields) . " WHERE id_usuario = :idUsuario";
                $paramsEmpresa[':idUsuario'] = $id;
    
                $stmtEmpresaUpdate = $this->conn->prepare($queryEmpresa);
                foreach ($paramsEmpresa as $key => $value) {
                    $stmtEmpresaUpdate->bindValue($key, $value);
                }
    
                $stmtEmpresaUpdate->execute();
            }

            $updateUserQuery = "UPDATE usuario SET ";
            $updateUserFields = [];
            $paramsUser = [];
            if ($foto_perfil !== null) {
                $updateUserFields[] = "foto_perfil = :fotoPerfil";
                $paramsUser[':fotoPerfil'] = $foto_perfil;
            }
            if ($telefono !== null && $telefono !== '') {
                $updateUserFields[] = "telefono = :telefono";
                $paramsUser[':telefono'] = $telefono;
            }
            if (count($updateUserFields) > 0) {
                $updateUserQuery .= implode(", ", $updateUserFields) . " WHERE id = :idUsuario";
                $paramsUser[':idUsuario'] = $id;
    
                $stmtUserUpdate = $this->conn->prepare($updateUserQuery);
                foreach ($paramsUser as $key => $value) {
                    $stmtUserUpdate->bindValue($key, $value);
                }
    
                $stmtUserUpdate->execute();
            }
    
            $this->conn->commit();
    
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al editar perfil: " . $e->getMessage();
            return false;
        }
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
                $estadoPostulacion = $this->obtenerEstadoPostulacion($postulacion['id_estadopostulacion']);
                $postulante = $this->obtenerPostulante($postulacion['id_usuario']);
                $postulacionObj = new Postulacion();

                $postulacionObj->setId($postulacion['id']);
                $postulacionObj->setFechaPostulacion($fechaPostulacion);
                $postulacionObj->setEstadoPostulacion($estadoPostulacion);
                $postulacionObj->setPostulante($postulante);

                $postulaciones[] = $postulacionObj;
            }
        }
        return $postulaciones;
    }
    public function cambiarEstadoPostulacion($postulacion_id, $nuevo_estado_id) {
        $sql = "UPDATE postulaciones SET id_estadopostulacion = :nuevo_estado_id WHERE id = :postulacion_id";
    
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bindParam(':nuevo_estado_id', $nuevo_estado_id, PDO::PARAM_INT);
        $stmt->bindParam(':postulacion_id', $postulacion_id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return null;
        }
    }
    public function cambiarEstadoPublicacion($publicacion_id, $nuevo_estado_id) {
        $sql = "UPDATE publicaciones_empleos SET id_estadopublicacion = :nuevo_estado_id WHERE id = :postulacion_id";
    
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bindParam(':nuevo_estado_id', $nuevo_estado_id, PDO::PARAM_INT);
        $stmt->bindParam(':postulacion_id', $publicacion_id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return null;
        }
    }
    
    public function obtenerAlumno($id) {
        $query = "SELECT u.id AS usuario_id, u.mail, u.telefono, u.direccion, u.foto_perfil,
                         a.id AS alumno_id, a.nombre AS alumno_nombre, a.apellido, a.descripcion, a.id_usuario,
                         ca.id_carrera,
                         ma.id_materia AS materia_id, m.nombre AS materia_nombre
                  FROM alumno AS a
                  JOIN usuario AS u ON u.id = a.id_usuario
                  LEFT JOIN carreras_alumnos AS ca ON ca.id_usuario = u.id
                  LEFT JOIN materias_aprobadas AS ma ON ma.id_alumno = a.id
                  LEFT JOIN materias AS m ON m.id = ma.id_materia
                  WHERE a.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $alumno = new Alumno();
            $alumno->setId($row['alumno_id']);
            $alumno->setNombreAlumno($row['alumno_nombre']);
            $alumno->setApellidoAlumno($row['apellido']);
            $alumno->setEmail($row['mail']);
            $alumno->setTelefono($row['telefono']);
            $alumno->setUbicacion($row['direccion']);
            if ($row['descripcion']) {
                $alumno->setDescripcion($row['descripcion']);
            } else {
                $alumno->setDescripcion('');
            }
    
            if ($row['foto_perfil']) {
                $alumno->setFotoPerfil($row['foto_perfil']);
            } else {
                $alumno->setFotoPerfil('');
            }
            $habilidades = $this->obtenerHabilidadesDelAlumno($id);
            $alumno->setHabilidades($habilidades);
    
            $carrera = $this->obtenerCarreraPorId($row['id_carrera']);
            if ($carrera) {
                $alumno->setCarrera($carrera);
            }
            $materiasAprobadas = [];
            do {
                if ($row['materia_id']) {
                    $materiasAprobadas[] = $row['materia_nombre'];
                }
            } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    
            $alumno->setMateriasAprobadas($materiasAprobadas);
    
            return $alumno;
        } else {
            return null;
        }
    }
    public function buscarAlumnos($query) {
        try {
            if ($query === '') {
                $sql = "SELECT alumno.nombre AS nombre_alumno, alumno.apellido, alumno.descripcion, alumno.id, usuario.foto_perfil 
                        FROM alumno 
                        JOIN usuario ON alumno.id_usuario = usuario.id";
            } else {
                $sql = "SELECT alumno.nombre AS nombre_alumno, alumno.apellido, alumno.descripcion, alumno.id, usuario.foto_perfil 
                        FROM alumno 
                        JOIN usuario ON alumno.id_usuario = usuario.id
                        WHERE alumno.nombre LIKE :query OR 
                              alumno.apellido LIKE :query OR 
                              alumno.descripcion LIKE :query";
            }
    
            $stmt = $this->conn->prepare($sql);
    
            if ($query !== '') {
                $stmt->bindValue(':query', '%' . $query . '%');
            }
    
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result; 
    
        } catch (Exception $e) {
            echo "Error en la búsqueda: " . $e->getMessage();
            return false;
        }
    }
    public function obtenerCarreraPorId($idCarrera) {
        $query = "SELECT * FROM carreras WHERE id = :id_carrera";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_carrera', $idCarrera, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $carrera = new Carrera();
            $carrera->setId($row['id']);
            $carrera->setNombreCarrera($row['nombre_carrera']);
            
            return $carrera;
        }
        return null;
    }
    
    public function obtenerHabilidadesDelAlumno($idAlumno) {
        $query = "SELECT h.id, h.descripcion, ha.nivel_grado
                  FROM habilidades AS h
                  JOIN habilidades_alumnos AS ha ON h.id = ha.id_habilidad
                  WHERE ha.id_usuario = :id_usuario";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $idAlumno, PDO::PARAM_INT);
        $stmt->execute();
        
        $habilidades = [];
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $habilidad = new Habilidad();
                $habilidad->setId($row['id']);
                $habilidad->setNombreHabilidad($row['descripcion']);
                $habilidad->setNivelHabilidad($row['nivel_grado']);

                $habilidades[] = $habilidad;
            }
        }
        
        return $habilidades;
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
                $carreraOBJ = new Carrera();
                $carreraOBJ->setId($id);
                $carreraOBJ->setNombreCarrera($nombreCarrera);
                $carreraOBJ->setPlanEstudios($planEstudios);
                $carrerasArray[] = $carreraOBJ;
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
    
    public function obtenerEstadoEmpleo($id_estadopublicacion) {
        $query = "SELECT * FROM estados_publicacion WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_estadopublicacion, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $estadoPublicacion = new EstadoEmpleo();
            $estadoPublicacion->setId($row['id']);
            $estadoPublicacion->setEstado($row['nombre']);
            
            return $estadoPublicacion;
        } else {
            return null;
        }
    }
    public function listarPublicaciones($idUsuario) {
        $queryPublicaciones = "SELECT * FROM publicaciones_empleos WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($queryPublicaciones);
        $stmt->bindParam(":id", $idUsuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $publicacionesArray = [];
            foreach($publicaciones as $publicacion){
                $publicacionOBJ = new PublicacionEmpleo();
                $estadoEmpleo = $this->obtenerEstadoEmpleo($publicacion['id_estadopublicacion']);
                $fechaPostulacion = DateTime::createFromFormat('Y-m-d', $publicacion['fecha']);
                $publicacionOBJ->setId($publicacion['id']);
                $publicacionOBJ->setTitulo($publicacion['puesto_ofrecido']);
                $publicacionOBJ->setDescripcion($publicacion['descripcion']);
                $publicacionOBJ->setFecha($fechaPostulacion);
                $publicacionOBJ->setUbicacion($publicacion['ubicacion']);
                $publicacionOBJ->setEstadoEmpleo($estadoEmpleo);
                $publicacionesArray[] = $publicacionOBJ;
            }
            if($publicacionesArray){
                return $publicacionesArray;
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
                $jornadasArray[] = $jornadaOBJ;
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
                $modalidadesArray[] = $modalidadOBJ;
            }
            if($modalidadesArray){
                return $modalidadesArray;
            }
        }
        return null;
    }
    
    
}