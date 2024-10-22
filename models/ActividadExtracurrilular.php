<?php

class ActividadExtraCurricular {
    private int $id;
    private string $nombreActividad;
    private string $tipoActividad;
    private string $duracionActividad;
    private string $certificacion;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombreActividad(): string {
        return $this->nombreActividad;
    }

    public function setNombreActividad(string $nombreActividad): void {
        $this->nombreActividad = $nombreActividad;
    }

    public function getTipoActividad(): string {
        return $this->tipoActividad;
    }

    public function setTipoActividad(string $tipoActividad): void {
        $this->tipoActividad = $tipoActividad;
    }

    public function getDuracionActividad(): string {
        return $this->duracionActividad;
    }

    public function setDuracionActividad(string $duracionActividad): void {
        $this->duracionActividad = $duracionActividad;
    }

    public function getCertificacion(): string {
        return $this->certificacion;
    }

    public function setCertificacion(string $certificacion): void {
        $this->certificacion = $certificacion;
    }
}

?>
