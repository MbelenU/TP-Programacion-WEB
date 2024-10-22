<?php
class Suscripcion {
    private int $id;
    private DateTime $fechaSuscripcion;
    private Alumno $alumno;
    private Evento $evento;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getFechaSuscripcion(): DateTime {
        return $this->fechaSuscripcion;
    }

    public function setFechaSuscripcion(DateTime $fechaSuscripcion): void {
        $this->fechaSuscripcion = $fechaSuscripcion;
    }

    public function getAlumno(): Alumno {
        return $this->alumno;
    }

    public function setAlumno(Alumno $alumno): void {
        $this->alumno = $alumno;
    }

    public function getEvento(): Evento {
        return $this->evento;
    }

    public function setEvento(Evento $evento): void {
        $this->evento = $evento;
    }
}

?>