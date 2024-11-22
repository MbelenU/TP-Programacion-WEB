<?php
require_once 'Database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Evento.php';

class AdministradorDAO
{

    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
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
                $evento->setId((int)$row['id']);
                $evento->setNombreEvento($row['nombre']);
                $evento->setFechaEvento($row['fecha']);
                $evento->setDescripcionEvento($row['descripcion']);
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
}

?>