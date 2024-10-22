<?php
class Postulacion {
    private int $id;
    private DateTime $fechaPostulacion;
    private EstadoPostulacion $estadoPostulacion;
    private Alumno $postulante;
    private PublicacionEmpleo $publicacionEmpleo;

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

    public function getPostulante(): Alumno {
        return $this->postulante;
    }

    public function setPostulante(Alumno $postulante): void {
        $this->postulante = $postulante;
    }

    public function getPublicacionEmpleo(): PublicacionEmpleo {
        return $this->publicacionEmpleo;
    }

    public function setPublicacionEmpleo(PublicacionEmpleo $publicacionEmpleo): void {
        $this->publicacionEmpleo = $publicacionEmpleo;
    }
}

?>