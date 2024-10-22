<?php

class Empresa extends Usuario{
    private array $empleosPubilcados;
    private array $eventos;

    public function __construct() {}

    public function getEmpleosPubilcados(): array {
        return $this->empleosPubilcados;
    }

    public function setEmpleosPubilcados(string $empleosPubilcados): string {
        $this->empleosPubilcados = $empleosPubilcados;
    }

    public function getEventos(): array {
        return $this->eventos;
    }

    public function setEventos(string $eventos): string {
        $this->eventos = $eventos;
    }
}
?>