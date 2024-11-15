<?php
class Postulacion {
    private int $id;
    private string $puestoOfrecido;
    private string $descripcion;
    private string $ubicacion;
    private array  $habilidades;
    private string $modalidad;
    private string $jornada;
    private string $estadoPostulacion;
    private Usuario $postulante;

    public function __construct(
        int $id, 
        string $puestoOfrecido, 
        string $descripcion, 
        string $ubicacion, 
        array  $habilidades, 
        string $modalidad, 
        string $jornada,        
        string $estadoPostulacion, 
        Usuario $postulante) {
            $this->setId($id);
            $this->setPuestoOfrecido($puestoOfrecido);
            $this->setDescripcion($descripcion);
            $this->setUbicacion($ubicacion);
            $this->setHabilidades($habilidades);
            $this->setModalidad($modalidad);
            $this->setJornada($jornada);            
            $this->setEstadoPostulacion($estadoPostulacion);
            $this->setPostulante($postulante);
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getPuestoOfrecido(): string {
        return $this->puestoOfrecido;
    }

    public function setPuestoOfrecido(string $puestoOfrecido): void {
        $this->puestoOfrecido = $puestoOfrecido;
    }

    public function getEstadoPostulacion(): string  {
        return $this->estadoPostulacion;
    }

    public function setEstadoPostulacion(string  $estadoPostulacion): void {
        $this->estadoPostulacion = $estadoPostulacion;
    }

    public function getPostulante(): Usuario {
        return $this->postulante;
    }

    public function setPostulante(Usuario $postulante): void {
        $this->postulante = $postulante;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getUbicacion(): string {
        return $this->ubicacion;
    }

    public function setUbicacion(string $ubicacion): void {
        $this->ubicacion = $ubicacion;
    }

    public function getHabilidades(): array {
        return $this->habilidades;
    }
    
    public function setHabilidades(array $habilidades): void {
        $this->habilidades = $habilidades;
    }    

    public function getModalidad(): string {
        return $this->modalidad;
    }

    public function setModalidad(string $modalidad): void {
        $this->modalidad = $modalidad;
    }

    public function getJornada(): string {
        return $this->jornada;
    }

    public function setJornada(string $jornada): void {
        $this->jornada = $jornada;
    }
}


?>