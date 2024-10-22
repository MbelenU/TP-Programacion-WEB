<?php
class Materia {
    private int $id;
    private string $nombreMateria;
    private Carrera $carreradeMateria;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombreMateria(): string {
        return $this->nombreMateria;
    }

    public function setNombreMateria(string $nombreMateria): void {
        $this->nombreMateria = $nombreMateria;
    }

    public function getCarreradeMateria(): Carrera {
        return $this->carreradeMateria;
    }

    public function setCarreradeMateria(Carrera $carreradeMateria): void {
        $this->carreradeMateria = $carreradeMateria;
    }
}

?>