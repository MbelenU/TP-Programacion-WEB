<?php
require_once 'Database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Alumno.php';
require_once __DIR__ . '/../models/Habilidad.php';
require_once __DIR__ . '/../models/Evento.php';
require_once __DIR__ . '/../models/PublicacionEmpleo.php';
require_once __DIR__ . '/../models/Modalidad.php';
require_once __DIR__ . '/../models/EstadoEmpleo.php';
require_once __DIR__ . '/../models/Jornada.php';
require_once __DIR__ . '/../models/EstadoPostulacion.php';
require_once __DIR__ . '/../models/Postulacion.php';
require_once __DIR__ . '/../models/Suscripcion.php';

class AlumnoDAO
{

    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }
    public function editarPerfilAlumno($id, $email, $username, $password, $nombre, $apellido, $telefono, $direccion, $fotoPerfil, $deBaja, $habilidades, $planEstudios, $materias): ?Alumno
    {
        // Actualizar información del usuario
        $updateUserQuery = "UPDATE usuario SET ";
        $updateUserFields = [];
        $paramsUser = [];

        if ($email !== null) {
            $updateUserFields[] = "mail = :email";
            $paramsUser[':email'] = $email;
        }
        if ($username !== null) {
            $updateUserFields[] = "nombre = :username";
            $paramsUser[':username'] = $username;
        }
        if ($password !== null) {
            $updateUserFields[] = "clave = :password";
            $paramsUser[':password'] = $password;
        }
        if ($telefono !== null) {
            $updateUserFields[] = "telefono = :telefono";
            $paramsUser[':telefono'] = $telefono;
        }
        if ($direccion !== null) {
            $updateUserFields[] = "direccion = :direccion";
            $paramsUser[':direccion'] = $direccion;
        }
        if ($fotoPerfil !== null) {
            $updateUserFields[] = "foto_perfil = :fotoPerfil";
            $paramsUser[':fotoPerfil'] = $fotoPerfil;
        }
        if ($deBaja !== null) {
            $updateUserFields[] = "de_baja = :deBaja";
            $paramsUser[':deBaja'] = $deBaja;
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

        $updateAlumnoQuery = "UPDATE alumno SET ";
        $updateAlumnoFields = [];
        $paramsAlumno = [];

        if ($nombre !== null) {
            $updateAlumnoFields[] = "nombre = :nombre";
            $paramsAlumno[':nombre'] = $nombre;
        }
        if ($apellido !== null) {
            $updateAlumnoFields[] = "apellido = :apellido";
            $paramsAlumno[':apellido'] = $apellido;
        }

        // if ($dni !== null) {
        //     $updateAlumnoFields[] = "DNI_Alumno = :dni";
        //     $paramsAlumno[':dni'] = $dni;
        // }

        if (count($updateAlumnoFields) > 0) {
            $updateAlumnoQuery .= implode(", ", $updateAlumnoFields) . " WHERE id_usuario = :idUsuario";
            $paramsAlumno[':idUsuario'] = $id;

            $stmtAlumnoUpdate = $this->conn->prepare($updateAlumnoQuery);
            foreach ($paramsAlumno as $key => $value) {
                $stmtAlumnoUpdate->bindValue($key, $value);
            }

            $stmtAlumnoUpdate->execute();
        }


        $habilidades = json_decode($habilidades, true); // Aseguramos que es un array
        if (!is_array($habilidades)) {
            $habilidades = [];  // En caso de que no sea un array, lo inicializamos como un array vacío
        }

        // Verificar las habilidades actuales del usuario
        $queryHabilidadesActuales = "
            SELECT id_habilidad FROM habilidades_alumnos WHERE id_usuario = :idAlumno
        ";
        $stmtHabilidades = $this->conn->prepare($queryHabilidadesActuales);
        $stmtHabilidades->bindValue(':idAlumno', $id);
        $stmtHabilidades->execute();

        $habilidadesExistentes = $stmtHabilidades->fetchAll(PDO::FETCH_COLUMN);

        // Verificar si $habilidadesExistentes es un array
        if (!is_array($habilidadesExistentes)) {
            $habilidadesExistentes = [];
        }

        // Encontrar las habilidades que ya no están en la lista de habilidades
        $habilidadesAEliminar = array_diff($habilidadesExistentes, $habilidades);

        // Eliminar las habilidades que ya no están asociadas al usuario
        if (count($habilidadesAEliminar) > 0) {
            $queryEliminarHabilidades = "
        DELETE FROM habilidades_alumnos 
        WHERE id_usuario = :idAlumno AND id_habilidad IN (" . implode(",", array_map('intval', $habilidadesAEliminar)) . ")
    ";
            $stmtEliminar = $this->conn->prepare($queryEliminarHabilidades);
            $stmtEliminar->bindValue(':idAlumno', $id);
            $stmtEliminar->execute();
        }

        // Encontrar las habilidades que no están asociadas y agregar las nuevas
        $habilidadesANuevas = array_diff($habilidades, $habilidadesExistentes);

        // Insertar las nuevas habilidades
        if (count($habilidadesANuevas) > 0) {
            $queryAgregarHabilidades = "
        INSERT INTO habilidades_alumnos (id_usuario, id_habilidad) 
        VALUES (:idAlumno, :idHabilidad)
    ";
            $stmtAgregar = $this->conn->prepare($queryAgregarHabilidades);

            foreach ($habilidadesANuevas as $habilidadId) {
                $stmtAgregar->bindValue(':idAlumno', $id);
                $stmtAgregar->bindValue(':idHabilidad', $habilidadId);
                $stmtAgregar->execute();
            }
        }

        return $this->obtenerAlumnoPorId($id);
    }


    private function obtenerAlumnoPorId($id): ?Alumno
    {
        // Implementación de consulta para obtener el Alumno por su ID (FK_idUsuario)
        $query = "SELECT * FROM alumno WHERE id_usuario = :idUsuario LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUsuario', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $rowAlumno = $stmt->fetch(PDO::FETCH_ASSOC);
            $alumno = new Alumno();
            $alumno->setNombre($rowAlumno['nombre']);
            $alumno->setApellidoAlumno($rowAlumno['apellido']);
            // Añadir más propiedades según sea necesario
            return $alumno;
        }

        return null;
    }


    private function obtenerUsuarioPorId($id): ?Usuario 
    {
        
        $query = "SELECT * FROM usuario WHERE id = :idUsuario LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUsuario', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $rowUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $usuario  = new Alumno();
            $usuario->setId($rowUsuario['id']);
            $usuario->setEmail($rowUsuario['mail']);
            return $usuario;
        }

        return null;
    }

    public function getHabilidades()
    {
        $query = "SELECT * FROM habilidades";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $habilidades = [];

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $habilidad = new Habilidad();

                $habilidad->setId($row['id']);
                $habilidad->setNombreHabilidad($row['descripcion']);

                $habilidades[] = $habilidad;
            }
        }

        return $habilidades;
    }


    

    public function getEventos() {
        $queryEventos = "SELECT * FROM eventos";
        $stmt = $this->conn->prepare($queryEventos);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $eventosArray = [];
            foreach($eventos as $evento){
                $id = $evento['id'];
                $descripcion = $evento['descripcion'];
                $nombre = $evento['nombre'];
                $fecha = $evento['fecha'];
                $tipo = $evento['tipo'];
                $creditos = $evento['creditos'];
                //$ubicacion = $evento['ubicacion']; falta en la bbdd
                //$modalidad = $evento['modalidad']; falta en la bbdd
                
                $eventoOBJ = new Evento($id, $nombre, $fecha, $descripcion, $creditos, $tipo);
                //$eventoOBJ = new Evento($id, $nombre, $fecha, $ubicacion, $modalidad, $descripcion, $creditos, $tipo); agregando $ubicacion, $modalidad que falta en la bbdd
                $eventosArray[] = $eventoOBJ->toArray();
            }
            if($eventosArray){
                return $eventosArray;
            }
        }
        return null;
    }




    public function getPostulaciones() {
        $queryPostulaciones = "SELECT * FROM postulaciones";
        $stmt = $this->conn->prepare($queryPostulaciones);
        $stmt->execute();
    
        $postulacionesArray = [];
    
        if ($stmt->rowCount() > 0) {
            // todas las postulaciones
            $postulaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($postulaciones as $postulacion) {
                $id = $postulacion['id'];
                $puestoId = $postulacion['id_publicacionesempleos'];
                $postulanteId = $postulacion['id_usuario'];
                $estadoId = $postulacion['id_estadopostulacion'];
    
                // detalles de la publicación de empleo
                $queryPuesto = "SELECT * FROM publicaciones_empleos WHERE id = :puestoId";
                $stmtPuesto = $this->conn->prepare($queryPuesto);
                $stmtPuesto->bindParam(':puestoId', $puestoId);
                $stmtPuesto->execute();
                $puesto = $stmtPuesto->fetch(PDO::FETCH_ASSOC);
    
                // habilidades asociadas al puesto
                $queryHabilidades = "SELECT HD.descripcion FROM habilidades_publicaciones HP 
                                     JOIN habilidades HD ON HP.id_habilidad = HD.id
                                     WHERE HP.id_publicacion = :puestoId";
                $stmtHabilidades = $this->conn->prepare($queryHabilidades);
                $stmtHabilidades->bindParam(':puestoId', $puestoId);
                $stmtHabilidades->execute();
                $habilidades = $stmtHabilidades->fetchAll(PDO::FETCH_COLUMN);
    
                // modalidad asociada al puesto
                 $queryModalidad = "SELECT descripcion FROM modalidades WHERE id = :modalidadId";
                 $stmtModalidad = $this->conn->prepare($queryModalidad);
                 $stmtModalidad->bindParam(':modalidadId', $puesto['id_modalidad']);
                 $stmtModalidad->execute();
                 $modalidad = $stmtModalidad->fetch(PDO::FETCH_ASSOC)['descripcion'];
    
                // jornada asociada al puesto
                $queryJornada = "SELECT nombre FROM jornadas WHERE id = :jornadaId";
                $stmtJornada = $this->conn->prepare($queryJornada);
                $stmtJornada->bindParam(':jornadaId', $puesto['id_jornada']);
                $stmtJornada->execute();
                $jornada = $stmtJornada->fetch(PDO::FETCH_ASSOC)['nombre'];
    
                // estado de la postulación
                $queryEstado = "SELECT * FROM estados_postulacion WHERE id = :estadoId";
                $stmtEstado = $this->conn->prepare($queryEstado);
                $stmtEstado->bindParam(':estadoId', $estadoId);
                $stmtEstado->execute();
                $estado = $stmtEstado->fetch(PDO::FETCH_ASSOC);
                $estadoPostulacion = new EstadoPostulacion();
                $estadoPostulacion->setEstado($estado['nombre']);
                $estadoPostulacion->setEstado($estado['id']);
                // detalles del postulante (usuario)
                $usuario = $this->obtenerUsuarioPorId($postulanteId);
    
                
                $postulacionOBJ = new Postulacion();

                $postulacionOBJ->setId($id); 
                $postulacionOBJ->setPuestoOfrecido($puesto['puesto_ofrecido']);
                $postulacionOBJ->setDescripcion($puesto['descripcion']);
                $postulacionOBJ->setUbicacion($puesto['ubicacion']);
                $postulacionOBJ->setHabilidades($habilidades);
                $postulacionOBJ->setModalidad($modalidad);
                $postulacionOBJ->setJornada($jornada);
                $postulacionOBJ->setEstadoPostulacion($estadoPostulacion);
                $postulacionOBJ->setPostulante($usuario);
    
                $postulacionesArray[] = $postulacionOBJ;
            }
    
            return $postulacionesArray;
        }
    
        return null;
    }
    
    public function getJornadaById($jornadaId) {
        $query = "SELECT * FROM jornadas WHERE id = :jornadaId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':jornadaId', $jornadaId);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $jornadaId = new Jornada($row['id'], $row['nombre']);
          //  $descripcion = $jornadaId->getDescripcionJornada();
            return $jornadaId;
        } else {
            return null; 
        }
    }

    public function getEstadoById($estadoId) {
        $query = "SELECT * FROM estados_publicacion WHERE id = :estadoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':estadoId', $estadoId);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $estadoId = new EstadoEmpleo($row['id'], $row['nombre']);
            // $estadoId = new EstadoEmpleo();
            // $estadoId->setId($row['id']);
            // $estadoId->setEstado($row['nombre']);
            // $detalle = $estadoId->getEstado();
            return $estadoId;
        } else {
            return null; 
        }
    }


    public function getModalidadById($modalidadId) {
        $query = "SELECT * FROM modalidades WHERE id = :modalidadId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':modalidadId', $modalidadId);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // $modalidad = new Modalidad($row['id'], $row['descripcion']);                        
            // $descripcion = $modalidad->getDescripcionModalidad();
            $modalidad = new Modalidad($row['id'], $row['descripcion']);
            return $modalidad;
        } else {
            return null; 
        }
    }


    public function getEmpleos() {
        $queryEmpleos = "SELECT * FROM publicaciones_empleos";
        $stmt = $this->conn->prepare($queryEmpleos);
        $stmt->execute();
       
        if ($stmt->rowCount() > 0) {
            $empleos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            
            
            $empleosArray = [];
            foreach($empleos as $empleo){
                $id = $empleo['id'];
                $descripcion = $empleo['descripcion'];
                $titulo = $empleo['puesto_ofrecido'];
                $fecha = $empleo['fecha'];
                $modalidadId = $empleo['id_modalidad'];
                $modalidad = $this->getModalidadById($modalidadId);
                $estadoId = $empleo['id_estadopublicacion'];
                $estadoEmpleo = $this->getEstadoById($estadoId);
                $jornadaId =  $empleo['id_jornada'];
                $jornada = $this->getJornadaById($jornadaId);
                $ubicacion = $empleo['ubicacion']; 
                //$materiasRequeridas = $empleo['materiasRequeridas']; //falta en la bbdd//
                //$habilidadesRequeridas = $empleo['habilidadesRequeridas']; //falta en la bbdd//
                //$postulacion = $empleo['postulacion']; //falta en la bbdd//
                //$carreraRequerida = $empleo['carreraRequerida']; //falta en la bbdd//

                $queryHabilidades = "SELECT * FROM habilidades_publicaciones HP 
                                 JOIN habilidades HD ON HP.id_habilidad = HD.id
                                 WHERE HP.id_publicacion = :puestoId";
                $stmtHabilidades = $this->conn->prepare($queryHabilidades);
                $stmtHabilidades->bindParam(':puestoId', $id);
                $stmtHabilidades->execute();
                $habilidadesData = $stmtHabilidades->fetchAll(PDO::FETCH_ASSOC);
                
                // Crear los objetos Habilidad
                $habilidades = [];
                foreach ($habilidadesData as $habilidadData) {
                    $habilidad = new Habilidad();
                    $habilidad->setId($habilidadData['id']);
                    $habilidad->setNombreHabilidad($habilidadData['descripcion']);
                    $habilidades[] = $habilidad;
                }


                $empleoOBJ = new PublicacionEmpleo();
                $empleoOBJ->setId($id);  
                $empleoOBJ->setTitulo($titulo);  
                $empleoOBJ->setModalidad($modalidad);
                $empleoOBJ->setDescripcion($descripcion);  
                $empleoOBJ->setEstadoEmpleo($estadoEmpleo);  
                $empleoOBJ->setJornada($jornada);  
                $empleoOBJ->setUbicacion($ubicacion); 
                $empleoOBJ->setHabilidades($habilidades);

                //$empleoOBJ = new PublicacionEmpleo($id, $titulo, $modalidad, $descripcion, $estadoEmpleo, $jornada, $ubicacion);
                //$empleoOBJ = new PublicacionEmpleo($id, $titulo, $modalidad, $descripcion, $estadoEmpleo, $carreraRequerida, $jornada, $ubicacion, $postulacion, $materiasRequeridas, $habilidadesRequeridas);
                
                $empleosArray[] = $empleoOBJ;
            }
            if($empleosArray){
                return $empleosArray;
            }
        }
        return null;
    }


    public function getBusquedaEmpleo($buscar = null) {
        $query = "SELECT * FROM publicaciones_empleos";
    
        if (!empty($buscar)) {
            $query = " WHERE puesto_ofrecido LIKE :buscar OR ubicacion LIKE :buscar OR descripcion LIKE :buscar";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':buscar', "%$buscar%");
            $stmt->execute();
        } else {
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }
    
        $empleos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $empleos;
    }


    public function getSuscripciones() {
        
            $query = "SELECT * FROM suscripciones";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $suscripcion = new Suscripcion($row['id'], $row['id_usuario'],$row['id_evento']);
                return $suscripcion;
            } else {
                return null; 
            }

        }


}