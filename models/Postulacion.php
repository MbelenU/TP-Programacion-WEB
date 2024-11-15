<?php
class Postulacion {
    private int $id;
    private DateTime $fechaPostulacion;
    private string $puestoOfrecido;
    private string $descripcion;
    private string $ubicacion;
    private array  $habilidades;
    private string $modalidad;
    private string $jornada;
    private EstadoPostulacion $estadoPostulacion;
    private Usuario $postulante;
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
    public function getFechaPostulacion(): DateTime {
        return $this->fechaPostulacion;
    }

    public function setFechaPostulacion(DateTime $fechaPostulacion): void {
        $this->fechaPostulacion = $fechaPostulacion;
    }

    public function getEstadoPostulacion(): EstadoPostulacion  {
        return $this->estadoPostulacion;
    }

    public function setEstadoPostulacion(EstadoPostulacion  $estadoPostulacion): void {
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