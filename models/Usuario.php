<?php

abstract class Usuario {
    private int $id;
    private string $nombre;
    private string $email;
    private string $contraseña;
    private string $rol;
    private ?string $fotoPerfil;
    private string $ubicacion;
    private string $telefono;
    
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getContraseña(): string {
        return $this->contraseña;
    }

    public function setContraseña(string $contraseña): void {
        $this->contraseña = $contraseña;
    }

    public function getTelefono(): string {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void {
        $this->telefono = $telefono;
    }

    public function getUbicacion(): string {
        return $this->ubicacion;
    }

    public function setUbicacion(string $ubicacion): void {
        $this->ubicacion = $ubicacion;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getRol(): string {
        return $this->rol;
    }

    public function setRol(string $rol): void {
        $this->rol = $rol;
    }

    public function getFotoPerfil(): ?string {
        return $this->fotoPerfil;
    }

    public function setFotoPerfil(?string $fotoPerfil): void { 
        $this->fotoPerfil = $fotoPerfil;
    }

    public function __toString(): string {
        return "Nombre: $this->nombre";
    }
}
?>
