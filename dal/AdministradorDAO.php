<?php
require_once 'Database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Evento.php';
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
require_once __DIR__ . '/../models/Notificaciones.php';

class AdministradorDAO
{

    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }
    
    public function buscarUsuarios($query) {
        if ($query === '') {
            $sql = "SELECT * FROM usuario"; 
        } else {
            $sql = "SELECT * FROM usuario
                    WHERE nombre LIKE :buscar
                    OR mail LIKE :buscar";
        }
        $stmt = $this->conn->prepare($sql);
        if ($query !== '') {
            $stmt->bindValue(':buscar', '%' . $query . '%');
        }
        $stmt->execute();
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $usuarios = [];
        foreach ($result as $row) {
            $usuario = new Usuario();
            $usuario->setId($row['id']);
            $usuario->setNombre($row['nombre']);
            $usuario->setEmail($row['mail']);
            $usuario->setEstado($row['de_baja']);
            $usuarios[] = $usuario->toArray();
        }
        return $usuarios;

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


    public function crearEvento($idUsuario, $titulo, $tipo, $fecha, $hora, $descripcion, $creditos) {
        $queryCrearEvento = "INSERT INTO eventos (
                id_usuario, 
                id_estadoeventos, 
                nombre, 
                descripcion, 
                fecha, 
                tipo,
                creditos
            ) VALUES (
                :id_usuario, 
                :id_estadoeventos, 
                :nombre, 
                :descripcion, 
                :fecha, 
                :tipo,
                :creditos
            )";

        $fechaHora = "$fecha $hora:00";

        $estadoEventos = 1;
        try {
            $stmt = $this->conn->prepare($queryCrearEvento);

            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_estadoeventos', $estadoEventos, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fechaHora, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stmt->bindParam(':creditos', $creditos, PDO::PARAM_STR);
            $stmt->execute();
    
            return [
                'success' => true,
                'message' => 'Registro exitoso.'
            ];
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

    public function getEventos(?int $id = null): array {
        $query = "SELECT id, nombre, fecha, descripcion, creditos, tipo FROM eventos";
    
        if ($id !== null) {
            $query .= " WHERE id_usuario = :id";
        }
    
        try {
            $stmt = $this->conn->prepare($query);
    
            if ($id !== null) {
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            }

            $stmt->execute();
    
            $eventos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $evento = new Evento();
                $evento->setId((int)$row['id'] ?? '');
                $evento->setNombreEvento($row['nombre'] ?? '');
                $evento->setFechaEvento($row['fecha'] ?? '');
                $evento->setDescripcionEvento($row['descripcion'] ?? '');
                $evento->setCreditos((float)($row['creditos'] ?? 0));
                $evento->setTipoEvento($row['tipo'] ?? ''); 
                $eventos[] = $evento;
            }
            return $eventos;
        } catch (PDOException $e) {
            echo "Error al obtener eventos: " . $e->getMessage();
            return [];
        }
    }

    public function editarEvento($id, $titulo, $fecha, $tipo, $descripcion, $creditos){
        $updateEventoQuery = "UPDATE eventos SET ";
        $updateEventoFields = [];
        $paramsEvento = [];

        if ($titulo !== null) {
            $updateEventoFields[] = "nombre = :titulo";
            $paramsEvento[':titulo'] = $titulo;
        }

        if ($fecha !== null) {
            $updateEventoFields[] = "fecha = :fecha";
            $paramsEvento[':fecha'] = $fecha;
        }

        if ($tipo !== null) {
            $updateEventoFields[] = "tipo = :tipo";
            $paramsEvento[':tipo'] = $tipo;
        }

        if ($descripcion !== null) {
            $updateEventoFields[] = "descripcion = :descripcion";
            $paramsEvento[':descripcion'] = $descripcion;
        }

        if ($creditos !== null) {
            $updateEventoFields[] = "creditos = :creditos";
            $paramsEvento[':creditos'] = $creditos;
        }

        if (count($updateEventoFields) > 0) {
            $updateEventoQuery .= implode(", ", $updateEventoFields) . " WHERE id = :id";
            $paramsEvento[':id'] = $id;

            $stmtEventoUpdate = $this->conn->prepare($updateEventoQuery);
            foreach ($paramsEvento as $key => $value) {
                $stmtEventoUpdate->bindValue($key, $value);
            }

            $stmtEventoUpdate->execute();
        }

        return $this->obtenerEventoPorId($id);
    }


    public function agregarNotificacion($idUsuario, $descripcion)
    {
        $query = "INSERT INTO notificaciones (id_usuario, descripcion) VALUES (:id_usuario, :descripcion)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function obtenerNotificaciones($idUsuario)
    {
        $query = "SELECT * FROM notificaciones WHERE id_usuario = :id_usuario ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        $notificaciones = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $notificacion = new Notificacion();
            $notificacion->setId($row['id']);
            $notificacion->setIdUsuario($row['id_usuario']);
            $notificacion->setDescripcion($row['descripcion']);
            $notificaciones[] = $notificacion;
        }

        return $notificaciones;
    }

    public function obtenerAlumnos() {
        $query = "SELECT u.id FROM usuario u
                  JOIN roles_usuario ru ON u.id = ru.id_usuario
                  WHERE ru.id_rol = 2";  // 2 es el rol de alumno
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $alumnos;
        } catch (PDOException $e) {
            echo "Error al obtener los alumnos: " . $e->getMessage();
            return false;
        }
    }

    public function getAllHabilidades(): array
    {
        try {
            $query = "SELECT * FROM habilidades";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener habilidades: " . $e->getMessage());
            return [];
        }
    }

    public function searchHabilidad(string $query): array
    {
        try {
            $sql = "SELECT * FROM habilidades WHERE descripcion LIKE :search";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':search', '%' . $query . '%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al buscar habilidades: " . $e->getMessage());
            return [];
        }
    }

    public function addHabilidad(string $descripcion): bool
    {
        try {
            $checkQuery = "SELECT COUNT(*) FROM habilidades WHERE descripcion = :descripcion";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
            $checkStmt->execute();
            $count = $checkStmt->fetchColumn();
    

            if ($count > 0) {
                return false;
            }
    
            $query = "INSERT INTO habilidades (descripcion) VALUES (:descripcion)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error al agregar habilidad: " . $e->getMessage());
            return false;
        }
    }

    public function deleteHabilidad(int $id): bool 
    {
        try {
            $this->conn->beginTransaction();
    
            $queryAlumnos = "DELETE FROM habilidades_alumnos WHERE id_habilidad = :id";
            $stmtAlumnos = $this->conn->prepare($queryAlumnos);
            $stmtAlumnos->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtAlumnos->execute();
    
            $queryPublicaciones = "DELETE FROM habilidades_publicaciones WHERE id_habilidad = :id";
            $stmtPublicaciones = $this->conn->prepare($queryPublicaciones);
            $stmtPublicaciones->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtPublicaciones->execute();
    
            $queryHabilidad = "DELETE FROM habilidades WHERE id = :id";
            $stmtHabilidad = $this->conn->prepare($queryHabilidad);
            $stmtHabilidad->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtHabilidad->execute();
    
            $this->conn->commit();
    
            return true;
    
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error al eliminar habilidad y relaciones: " . $e->getMessage());
            return false;
        }
    }

    public function listarAlumnos() {
        $queryAlumnos = "SELECT alumno.nombre, 
                            alumno.apellido, 
                            alumno.descripcion, 
                            alumno.id, 
                            usuario.foto_perfil, 
                            c.nombre_carrera
                        FROM alumno
                        JOIN usuario ON alumno.id_usuario = usuario.id
                        LEFT JOIN carreras_alumnos ca ON ca.id_usuario = alumno.id_usuario
                        LEFT JOIN carreras c ON ca.id_carrera = c.id";
        
        $stmt = $this->conn->prepare($queryAlumnos);
        $stmt->execute();
        
        $alumnosArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($alumnosArray) > 0) {
            $alumnos = [];
            foreach ($alumnosArray as $alumno) {
                $alumnoOBJ = new Alumno();
                $alumnoOBJ->setId($alumno['id']);
                $alumnoOBJ->setNombreAlumno($alumno['nombre']);
                $alumnoOBJ->setApellidoAlumno($alumno['apellido']);
                $alumnoOBJ->setDescripcion($alumno['descripcion'] ? $alumno['descripcion'] : '');
                $alumnoOBJ->setFotoPerfil($alumno['foto_perfil'] ? $alumno['foto_perfil'] : '');

                $carrera = new Carrera();
                $carrera->setNombreCarrera($alumno['nombre_carrera'] ? $alumno['nombre_carrera'] : '');
                $alumnoOBJ->setCarrera($carrera); 
                $alumnos[] = $alumnoOBJ;
            }
            return $alumnos;
        } else {
            return null;
        }
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
    
    public function listarJornadas() {
        $queryJornadas = "SELECT * FROM jornadas";
        $stmt = $this->conn->prepare($queryJornadas);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $jornadas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $jornadasArray = [];
            foreach($jornadas as $jornada){
                $id = $jornada['id'];
                $descripcion = $jornada['nombre'];
                $jornadaOBJ = new Jornada($id, $descripcion);
                $jornadasArray[] = $jornadaOBJ;
            }
            if($jornadasArray){
                return $jornadasArray;
            }
        }
        return null;
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
        return [];
    }

    public function buscarAlumnos($query) {
        try {
            if ($query == '') {
                $sql = "
                SELECT alumno.nombre AS nombre_alumno, 
                       alumno.apellido, 
                       alumno.descripcion, 
                       alumno.id, 
                       usuario.foto_perfil, 
                       c.nombre_carrera
                FROM alumno
                JOIN usuario ON alumno.id_usuario = usuario.id
                LEFT JOIN carreras_alumnos ca ON ca.id_usuario = alumno.id_usuario
                LEFT JOIN carreras c ON ca.id_carrera = c.id";
                $stmt = $this->conn->prepare($sql);
            } else {
                $sql = "
                SELECT alumno.nombre AS nombre_alumno, 
                       alumno.apellido, 
                       alumno.descripcion, 
                       alumno.id, 
                       usuario.foto_perfil, 
                       c.nombre_carrera
                FROM alumno
                JOIN usuario ON alumno.id_usuario = usuario.id
                LEFT JOIN carreras_alumnos ca ON ca.id_usuario = alumno.id_usuario
                LEFT JOIN carreras c ON ca.id_carrera = c.id
                WHERE (alumno.nombre LIKE :query_nombre OR 
                       alumno.apellido LIKE :query_apellido OR 
                       alumno.descripcion LIKE :query_descripcion OR 
                       c.nombre_carrera LIKE :query_carrera)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':query_nombre', '%' . $query . '%');
                $stmt->bindValue(':query_apellido', '%' . $query . '%');
                $stmt->bindValue(':query_descripcion', '%' . $query . '%');
                $stmt->bindValue(':query_carrera', '%' . $query . '%');
            }
        


    
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $alumnos = [];
            foreach ($result as $row) {
                $alumno = new Alumno();
                $alumno->setId($row['id']);
                $alumno->setNombreAlumno($row['nombre_alumno']);
                $alumno->setDescripcion($row['descripcion']);
                $alumno->setApellidoAlumno($row['apellido']);
                $alumno->setFotoPerfil($row['foto_perfil']);
                $carrera = new Carrera();
                $carrera->setNombreCarrera($row['nombre_carrera']);
                $alumno->setCarrera($carrera);
    
                $alumnos[] = $alumno->toArray();
            }
    
            return $alumnos;
    
        } catch (Exception $e) {
            echo "Error en la búsqueda: " . $e->getMessage();
            return false;
        }
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

    public function reclutarAlumno($usuario_id, $postulacion_id, $estadoId) {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date('Y-m-d H:i:s');
        
    
        $checkQuery = "SELECT id_estadopostulacion  FROM postulaciones WHERE id_usuario = :idAlumno AND id_publicacionesempleos = :idPublicacionesEmpleos";
        $stmtCheck = $this->conn->prepare($checkQuery);
        $stmtCheck->bindParam(':idAlumno', $usuario_id, PDO::PARAM_INT);
        $stmtCheck->bindParam(':idPublicacionesEmpleos', $postulacion_id, PDO::PARAM_INT);
        
        try {
            $stmtCheck->execute();
            $result  = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                
                if ($result['id_estadopostulacion'] == 3) {
                    return ['success' => false, 'message' => 'Este usuario ya se encuentra reclutado.'];
                } else {

                $estadoId = 3; 
                $queryUpdate = "UPDATE postulaciones SET id_estadopostulacion = :id_estadopostulacion WHERE id_usuario = :idAlumno AND id_publicacionesempleos = :idPublicacionesEmpleos";
                $stmtUpdate = $this->conn->prepare($queryUpdate);
                $stmtUpdate->bindParam(':id_estadopostulacion', $estadoId, PDO::PARAM_INT);
                $stmtUpdate->bindParam(':idAlumno', $usuario_id, PDO::PARAM_INT);
                $stmtUpdate->bindParam(':idPublicacionesEmpleos', $postulacion_id, PDO::PARAM_INT);
                $stmtUpdate->execute();
                
                return ['success' => true, 'message' => 'Estado de postulación cambiado a Reclutado.'];
                }
            } else {
                $estadoId = 3;                 
                $queryInsert = "INSERT INTO postulaciones (id_usuario, id_publicacionesempleos, fecha, id_estadopostulacion) 
                                VALUES (:idAlumno, :idPublicacionesEmpleos, :fecha, :id_estadopostulacion)";
                
                $stmtInsert = $this->conn->prepare($queryInsert);
                $stmtInsert->bindParam(':idAlumno', $usuario_id, PDO::PARAM_INT);
                $stmtInsert->bindParam(':idPublicacionesEmpleos', $postulacion_id, PDO::PARAM_INT);
                $stmtInsert->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                $stmtInsert->bindParam(':id_estadopostulacion', $estadoId, PDO::PARAM_INT);
                $stmtInsert->execute();
                
                return ['success' => true, 'message' => 'Postulación creada con éxito como Reclutado.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al realizar la postulación: ' . $e->getMessage()];
        }
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
            $alumno->setUsuarioId($row['usuario_id']);
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

    public function obtenerPublicacionPorPostulacion($postulacion_id) {
        $sql = "SELECT pe.puesto_ofrecido, ep.nombre
                FROM postulaciones p
                JOIN publicaciones_empleos pe ON p.id_publicacionesempleos = pe.id
                JOIN estados_postulacion ep ON p.id_estadopostulacion = ep.id
                WHERE p.id = :postulacion_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':postulacion_id', $postulacion_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }
    
    public function obtenerAlumnosPorPostulacion($postulacion_id) {
        $sql = "SELECT u.id 
                FROM postulaciones p
                JOIN usuario u ON p.id_usuario = u.id
                WHERE p.id = :postulacion_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':postulacion_id', $postulacion_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
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



    public function eliminarEvento($eventoId) {
        try {

            // 1. Eliminar la suscripción asociada al evento
            $querySuscripcion = "DELETE FROM suscripciones WHERE id_evento = :evento_id";
            $stmtSuscripcion = $this->conn->prepare($querySuscripcion);
            $stmtSuscripcion->bindParam(':evento_id', $eventoId, PDO::PARAM_INT);

            // Ejecutar la eliminación de la suscripción
            if (!$stmtSuscripcion->execute()) {
                return false;
            }

            $queryEvento = "DELETE FROM eventos WHERE id = :evento_id";
            $stmtEvento = $this->conn->prepare($queryEvento);
            $stmtEvento->bindParam(':evento_id', $eventoId, PDO::PARAM_INT);


            if ($stmtEvento->execute()) {
                return true; 
            } else {
                return false; 
            }
            
        } catch (PDOException $e) {
            // Manejo de errores
            echo "Error: " . $e->getMessage();
            return false;
        }

    }

    public function obtenerEventoPorId($eventoId) {
        $query = "SELECT * FROM eventos WHERE id = :eventoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':eventoId', $eventoId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $eventoData = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($eventoData) {
                
                $evento = new Evento();
                $evento->setId($eventoData['id']);
                $evento->setNombreEvento($eventoData['nombre']);
          //      $evento->getModalidadEvento($eventoData['modalidad']);
                $evento->setFechaEvento($eventoData['fecha']);
                $evento->setDescripcionEvento($eventoData['descripcion']);
                $evento->setCreditos($eventoData['creditos']);

                return $evento;
            }
        }

        return null; //evento no encontrado 
    }

        public function obtenerInscriptos($eventoId) {

            $query = $query = "SELECT a.id_usuario,
                             a.nombre AS nombre_alumno,
                             a.apellido AS apellido_alumno
                      FROM suscripciones s
                      JOIN alumno a ON s.id_usuario = a.id_usuario
                      WHERE s.id_evento = :eventoId";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':eventoId', $eventoId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $inscriptos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $inscriptos;
            }

            return []; 
        }


        public function eliminarInscripto($eventoId, $idUsuario) {
            
            try {
    
                $querySuscripcion = "DELETE FROM suscripciones WHERE id_evento = :evento_id AND id_usuario = :idUsuario";
                $stmtSuscripcion = $this->conn->prepare($querySuscripcion);
                $stmtSuscripcion->bindParam(':evento_id', $eventoId, PDO::PARAM_INT);
                $stmtSuscripcion->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    
                if (!$stmtSuscripcion->execute()) {
                    return false;
                }
    
                return true; 

            } catch (PDOException $e) {
                // Manejo de errores
                echo "Error: " . $e->getMessage();
                return false;
            }
    
           
        }
        
    
}

?>