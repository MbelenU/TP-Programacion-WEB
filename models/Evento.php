<?php

class Evento {
    private int $id;
    private string $nombreEvento;
    private string $fechaEvento;
    private string $ubicacionEvento;
    private string $modalidadEvento;
    private array $suscripciones; // Lista de suscripciones
    private EstadoEvento $estadoEvento; // Objeto de la clase EstadoEvento

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombreEvento(): string {
        return $this->nombreEvento;
    }

    public function setNombreEvento(string $nombreEvento): void {
        $this->nombreEvento = $nombreEvento;
    }

    public function getFechaEvento(): string {
        return $this->fechaEvento;
    }

    public function setFechaEvento(string $fechaEvento): void {
        $this->fechaEvento = $fechaEvento;
    }

    public function getUbicacionEvento(): string {
        return $this->ubicacionEvento;
    }

    public function setUbicacionEvento(string $ubicacionEvento): void {
        $this->ubicacionEvento = $ubicacionEvento;
    }

    public function getModalidadEvento(): string {
        return $this->modalidadEvento;
    }

    public function setModalidadEvento(string $modalidadEvento): void {
        $this->modalidadEvento = $modalidadEvento;
    }

    public function getSuscripciones(): array {
        return $this->suscripciones;
    }

    public function setSuscripciones(array $suscripciones): void {
        $this->suscripciones = $suscripciones;
    }

    public function getEstadoEvento(): EstadoEvento {
        return $this->estadoEvento;
    }

    public function setEstadoEvento(EstadoEvento $estadoEvento): void {
        $this->estadoEvento = $estadoEvento;
    }
}

?>
