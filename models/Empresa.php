<?php

class Empresa extends Usuario{
    private array $empleosPublicados;
    private string $razonSocial;
    private string $CUIT;
    public function __construct() {}

    public function getEmpleos(): array {
        return $this->empleosPublicados;
    }
    public function setEmpleos(array $empleosPublicados) {
        $this->empleosPublicados = $empleosPublicados;
    }
    public function getRazonSocial(): string {
        return $this->razonSocial;
    }
    
    public function setRazonSocial(string $razonSocial) {
        $this->razonSocial = $razonSocial;
    }
    
    public function getCUIT(): string {
        return $this->CUIT;
    }
    public function setCUIT(string $CUIT) {
        $this->CUIT = $CUIT;
    }
}
?>
