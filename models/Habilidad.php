<?php

class Habilidad {
    private int $id;
    private string $nombreHabilidad;
    private string $nivelHabilidad;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombreHabilidad(): string {
        return $this->nombreHabilidad;
    }

    public function setNombreHabilidad(string $nombreHabilidad): void {
        $this->nombreHabilidad = $nombreHabilidad;
    }

    public function getNivelHabilidad(): string {
        return $this->nivelHabilidad;
    }

    public function setNivelHabilidad(string $nivelHabilidad): void {
        $this->nivelHabilidad = $nivelHabilidad;
    }
    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombreHabilidad' => $this->nombreHabilidad
        ];
    }
}

?>
