<?php

class PublicacionEmpleo {
    private int $id;
    private string $titulo;
    private string $descripcion;
    private Modalidad $modalidad;
    private EstadoEmpleo $estadoEmpleo;
    private Jornada $jornada;
    private string $ubicacion;
    private array $postulacion; // Lista de postulaciones
    private array $materiasRequeridas; // Lista de materias requeridas
    private DateTime $fecha;
    private array $habilidades;
    

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getFecha(): DateTime {
        return $this->fecha;
    }
    
    public function setFecha(DateTime $fecha): void {
        $this->fecha = $fecha;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void {
        $this->titulo = $titulo;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getModalidad(): Modalidad {
        return $this->modalidad;
    }

    public function setModalidad(Modalidad $modalidad): void {
        $this->modalidad = $modalidad;
    }

    public function getEstadoEmpleo(): estadoEmpleo {
        return $this->estadoEmpleo;
    }

    public function setEstadoEmpleo(estadoEmpleo $estadoEmpleo): void {
        $this->estadoEmpleo = $estadoEmpleo;
    }
    public function getJornada(): Jornada {
        return $this->jornada;
    }

    public function setJornada(Jornada $jornada): void {
        $this->jornada = $jornada;
    }

    public function getUbicacion(): string {
        return $this->ubicacion;
    }

    public function setUbicacion(string $ubicacion): void {
        $this->ubicacion = $ubicacion;
    }

    public function getPostulacion(): array {
        return $this->postulacion;
    }

    public function setPostulacion(array $postulacion): void {
        $this->postulacion = $postulacion;
    }

    public function getMateriasRequeridas(): array {
        return $this->materiasRequeridas;
    }

    public function setMateriasRequeridas(array $materiasRequeridas): void {
        $this->materiasRequeridas = $materiasRequeridas;
    }



    public function setHabilidades(array $habilidades): void {
        // Verificamos que todas las habilidades sean objetos de la clase Habilidad
        foreach ($habilidades as $habilidad) {
            if (!$habilidad instanceof Habilidad) {
                throw new Exception("Las habilidades deben ser objetos de la clase Habilidad");
            }
        }
        $this->habilidades = $habilidades;
    }

    // Método para obtener las habilidades (array de objetos Habilidad)
    public function getHabilidades(): array {
        return $this->habilidades;
    }


    public function toArray(): array {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'estadoEmpleo' => $this->estadoEmpleo,
            'jornada' => $this->jornada ? $this->jornada->getDescripcionJornada() : null,  // Asegúrate de que esté asignado
            'modalidad' => $this->modalidad ? $this->modalidad->getDescripcionModalidad() : null,  // Asegúrate de que esté asignado
            'ubicacion' => $this->ubicacion,
            'habilidades' => array_map(function($habilidad) {
                return $habilidad->toArray(); // Convertimos cada objeto Habilidad a un array
            }, $this->habilidades),
        ];
    }
}

?>
