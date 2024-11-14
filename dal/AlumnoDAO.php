<?php
require_once 'Database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Alumno.php';
require_once __DIR__ . '/../models/Habilidad.php';
require_once __DIR__ . '/../models/Evento.php';

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
}
