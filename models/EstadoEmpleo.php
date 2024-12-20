<?php

class EstadoEmpleo extends PublicacionEmpleo {
    private int $id;
    private string $estado;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getEstado(): string {
        return $this->estado;
    }

    public function setEstado(string $estado): void {
        $this->estado = $estado;
    }

    public function toArray(): array {
        return [
            'id' => $this->getId(),
            'estado' => $this->getEstado(),
        ];
    }
}

?>
