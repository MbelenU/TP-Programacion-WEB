<?php

class ExperienciaLaboral {
    private int $id;
    private string $empresa;
    private string $puesto;
    private string $duracion;
    private string $detallesDeTareas;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getEmpresa(): string {
        return $this->empresa;
    }

    public function setEmpresa(string $empresa): void {
        $this->empresa = $empresa;
    }

    public function getPuesto(): string {
        return $this->puesto;
    }

    public function setPuesto(string $puesto): void {
        $this->puesto = $puesto;
    }

    public function getDuracion(): string {
        return $this->duracion;
    }

    public function setDuracion(string $duracion): void {
        $this->duracion = $duracion;
    }

    public function getDetallesDeTareas(): string {
        return $this->detallesDeTareas;
    }

    public function setDetallesDeTareas(string $detallesDeTareas): void {
        $this->detallesDeTareas = $detallesDeTareas;
    }
}

?>
