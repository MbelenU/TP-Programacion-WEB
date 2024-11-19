<?php

class Jornada {
    private int $id;
    private string $descripcionJornada;
    public function __construct(int $id, string $descripcion) {
        $this->setId($id);
        $this->setDescripcionJornada($descripcion);
    }
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getDescripcionJornada(): string {
        return $this->descripcionJornada;
    }

    public function setDescripcionJornada(string $descripcionJornada): void {
        $this->descripcionJornada = $descripcionJornada;
    }
    public function toArray(): array {
        return [
            'id' => $this->id,
            'descripcion' => $this->descripcionJornada
        ];
    }
}

?>
