<?php

class Empresa extends Usuario{
    private string $telefono;
    private string $contraseña;
    private array $empleosPublicados;
    private string $descripcion;
    private string $ubicacion;

    public function __construct() {}

    public function getTelefono(): string {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void {
        $this->telefono = $telefono;
    }

    public function getContraseña(): string {
        return $this->contraseña;
    }

    public function setContraseña(string $contraseña): void {
        $this->contraseña = $contraseña;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function getUbicacion(): string {
        return $this->ubicacion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function setUbicacion(string $ubicacion): void {
        $this->ubicacion = $ubicacion;
    }
}
?>