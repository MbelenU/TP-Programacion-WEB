<?php

class Jornada extends PublicacionEmpleo {
    private int $id;
    private string $descripcionJornada;

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
}

?>
