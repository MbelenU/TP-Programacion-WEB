<?php
class Postulacion {
    private int $id;
    private DateTime $fechaPostulacion;
    private EstadoPostulacion $estadoPostulacion;
    private Usuario $postulante;

    public function __construct(int $id, DateTime $fechaPostulacion, EstadoPostulacion $estadoPostulacion, Usuario $postulante) {
        $this->setId($id);
        $this->setFechaPostulacion($fechaPostulacion);
        $this->setEstadoPostulacion($estadoPostulacion);
        $this->setPostulante($postulante);
    }
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getFechaPostulacion(): DateTime {
        return $this->fechaPostulacion;
    }

    public function setFechaPostulacion(DateTime $fechaPostulacion): void {
        $this->fechaPostulacion = $fechaPostulacion;
    }

    public function getEstadoPostulacion(): EstadoPostulacion {
        return $this->estadoPostulacion;
    }

    public function setEstadoPostulacion(EstadoPostulacion $estadoPostulacion): void {
        $this->estadoPostulacion = $estadoPostulacion;
    }

    public function getPostulante(): Usuario {
        return $this->postulante;
    }

    public function setPostulante(Usuario $postulante): void {
        $this->postulante = $postulante;
    }
}

?>