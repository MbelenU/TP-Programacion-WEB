<?php

class Modalidad extends PublicacionEmpleo {
    private int $id;
    private string $descripcionModalidad;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getDescripcionModalidad(): string {
        return $this->descripcionModalidad;
    }

    public function setDescripcionModalidad(string $descripcionModalidad): void {
        $this->descripcionModalidad = $descripcionModalidad;
    }
}

?>
