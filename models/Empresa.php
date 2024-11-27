<?php

class Empresa extends Usuario {
    private array $empleosPublicados;
    private string $descripcion;
    private string $nombreEmpresa;
    private string $mailCorporativo;
    private ?string $sitioWeb; 

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }
    public function getNombreEmpresa(): string {
        return $this->nombreEmpresa;
    }
    public function setNombreEmpresa(string $nombreEmpresa): void {
        $this->nombreEmpresa = $nombreEmpresa;
    }
    public function getEmpleosPublicados(): array {
        return $this->empleosPublicados;
    }

    public function setEmpleosPublicados(array $empleos): void {
        $this->empleosPublicados = $empleos;
    }

    public function getMailCorporativo(): string {
        return $this->mailCorporativo;
    }

    public function setMailCorporativo(string $mailCorporativo): void {
        $this->mailCorporativo = $mailCorporativo;
    }
    public function getSitioWeb(): ?string {
        return $this->sitioWeb; 
    }

    public function setSitioWeb(?string $sitioWeb): void {
        $this->sitioWeb = $sitioWeb; 
    }
}
?>
