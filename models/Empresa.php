<?php

class Empresa extends Usuario {
    private array $empleosPublicados;
    private string $descripcion;
    private string $mailCorporativo;

    public function getDescripcion(): string {
        return $this->descripcion;
    }
    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
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
    public function setMailCorporativo(string $telefonoCorporativo): void {
        $this->mailCorporativo = $telefonoCorporativo;
    }

}
?>
