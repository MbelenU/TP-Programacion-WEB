<?php

class Alumno extends Usuario {
    private int $id;
    private string $nombreAlumno;
    private string $apellidoAlumno;
    private string $fotoDePerfil;
    // private Carrera $carrera;
    private array $habilidades;
    private array $actividadExtraCurricular;
    private array $experienciasLaborales;
    private array $suscripciones;
    private array $empleosPostulados;


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

    public function getApellidoAlumno(): string {
        return $this->apellidoAlumno;
    }

    public function setApellidoAlumno(string $apellidoAlumno): void {
        $this->apellidoAlumno = $apellidoAlumno;
    }
    public function getFotoDePerfil(): string {
        return $this->fotoDePerfil;
    }

    public function setFotoDePerfil(string $fotoDePerfil): void {
        $this->fotoDePerfil = $fotoDePerfil;
    }

    // public function getCarrera(): Carrera {
    //     return $this->carrera;
    // }

    // public function setCarrera(Carrera $carrera): void {
    //     $this->carrera = $carrera;
    // }

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
    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombreAlumno,
            'apellido' => $this->apellidoAlumno
        ];
    }
    public function __toString(): string {
        $usuarioString = parent::__toString(); // Llama al método __toString() de la clase padre
        return "$usuarioString, Apellido: $this->apellidoAlumno";
    }
}
?>