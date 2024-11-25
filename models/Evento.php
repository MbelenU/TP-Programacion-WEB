<?php

class Evento {
    private int $id;
    private string $nombreEvento;
    private string $fechaEvento;
    private string $ubicacionEvento;
    private string $modalidadEvento;
    private string $descripcionEvento;
    private float $creditos;//agregado
    private string $tipoEvento;//agregado
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

    public function getDescripcionEvento(): string {
        return $this->descripcionEvento;
    }
    

    public function setDescripcionEvento(string $descripcionEvento) : void {
        $this->descripcionEvento = $descripcionEvento;
    }

    public function toArray(): array {
        return [
            'idEvento'=>$this->id,
            'descripcionEvento'=>$this->descripcionEvento,
            'nombreEvento'=>$this->nombreEvento,
            'fechaEvento'=>$this->fechaEvento,
            'tipoEvento'=>$this->tipoEvento,
            'creditosEvento'=>$this->creditos
            //'ubicacion'=>$this->ubicacion,
            //'modalidad'=>$this->modalidad,

        ];
    }

    public function getCreditos(): float {
        return $this->creditos;
    }

    public function setCreditos(float $creditos): void {
        $this->creditos = $creditos;
    }

    public function getTipoEvento(): string {
        return $this->tipoEvento;
    }

    public function setTipoEvento(string $tipoEvento): void {
        $this->tipoEvento = $tipoEvento;
    }
    
}


?>