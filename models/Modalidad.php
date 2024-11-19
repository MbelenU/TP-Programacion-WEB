<?php

class Modalidad {
    private int $id;
    private string $descripcionModalidad;

    public function __construct(int $id, string $descripcionModalidad) {
        $this->id = $id;  // Valor por defecto
        $this->descripcionModalidad = $descripcionModalidad;  // Valor por defecto
    }

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
    public function toArray(): array {
        return [
            'id' => $this->id,
            'descripcion' => $this->descripcionModalidad
        ];
    }
}

?>
