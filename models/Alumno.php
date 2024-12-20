<?php

class Alumno extends Usuario {
    private int $id;
    private string $id_usuario;
    private string $nombreAlumno;
    private string $apellidoAlumno;
    private string $descripcion;
    private array $habilidades;
    private array $actividadExtraCurricular;
    private array $experienciasLaborales;
    private array $suscripciones;
    private array $empleosPostulados;
    private ?Carrera $carrera = null;
    private array $materiasAprobadas;

    public function getMateriasAprobadas(): array {
        return $this->materiasAprobadas;
    }

    public function setMateriasAprobadas(array $materiasAprobadas): void {
        $this->materiasAprobadas = $materiasAprobadas;
    }

    public function getUsuarioId() {
        return $this->id_usuario;  
    }
    
    public function setUsuarioId(int $id_usuario): void {
        $this->id_usuario = $id_usuario;
    }



    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombreAlumno(): string {
        return $this->nombreAlumno;
    }

    public function setNombreAlumno(string $nombreAlumno): void {
        $this->nombreAlumno = $nombreAlumno;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getApellidoAlumno(): string {
        return $this->apellidoAlumno;
    }

    public function setApellidoAlumno(string $apellidoAlumno): void {
        $this->apellidoAlumno = $apellidoAlumno;
    }
    public function getHabilidades(): array {
        return $this->habilidades;
    }

    public function setHabilidades(array $habilidades): void {
        $this->habilidades = $habilidades;
    }

    public function getActividadExtraCurricular(): array {
        return $this->actividadExtraCurricular;
    }

    public function setActividadExtraCurricular(array $actividadExtraCurricular): void {
        $this->actividadExtraCurricular = $actividadExtraCurricular;
    }

    public function getExperienciasLaborales(): array {
        return $this->experienciasLaborales;
    }

    public function setExperienciasLaborales(array $experienciasLaborales): void {
        $this->experienciasLaborales = $experienciasLaborales;
    }

    public function getSuscripciones(): array {
        return $this->suscripciones;
    }

    public function setSuscripciones(array $suscripciones): void {
        $this->suscripciones = $suscripciones;
    }

    public function getEmpleosPostulados(): array {
        return $this->empleosPostulados;
    }

    public function setEmpleosPostulados(array $empleosPostulados): void {
        $this->empleosPostulados = $empleosPostulados;
    }

    public function getCarrera(): ?Carrera {
        return $this->carrera;
    }

    public function setCarrera(Carrera $carrera): void {
        $this->carrera = $carrera;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombreAlumno,
            'apellido' => $this->apellidoAlumno,
            'descripcion' => $this->descripcion,
            'fotoPerfil' => $this->getFotoPerfil(),
            'carrera' => $this->carrera->toArray()
        ];
    }

    public function __toString(): string {
        $usuarioString = parent::__toString(); 
        return "$usuarioString, Apellido: $this->apellidoAlumno";
    }
}
?>
