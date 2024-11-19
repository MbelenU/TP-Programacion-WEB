<?php

class Empresa extends Usuario{
    private array $empleosPubilcados;
    private array $eventos;

    public function __construct() {}

    public function getEmpleosPubilcados(): array {
        return $this->empleosPubilcados;
    }

    public function setEmpleosPubilcados(string $empleosPubilcados): void {
        $this->empleosPubilcados = $empleosPubilcados;
    }

    public function getEventos(): array {
        return $this->eventos;
    }

    public function setEventos(string $eventos): void {
        $this->eventos = $eventos;
    }
}
?>