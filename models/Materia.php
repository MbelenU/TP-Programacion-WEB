<?php
class Materia {
    private int $id;
    private string $nombreMateria;
    private string $detalleMateria;
    public function __construct(int $id, string $nombreMateria, string $detalleMateria) {
        $this->setId($id);
        $this->setNombreMateria($nombreMateria);
        $this->setDetalleMateria($detalleMateria);
    }
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

    public function getDetalleMateria(): string {
        return $this->detalleMateria;
    }

    public function setDetalleMateria(string $detalleMateria): void {
        $this->detalleMateria = $detalleMateria;
    }
    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombreMateria' => $this->nombreMateria,
            'detalleMateria' => $this->detalleMateria
        ];
    }
}

?>