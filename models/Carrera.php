<?php
class Carrera {
    private int $id;
    private string $nombreCarrera;
    private array $planEstudios; 
    public function __construct(int $id, string $nombreCarrera, array $planEstudios) {
        $this->setId($id);
        $this->setNombreCarrera($nombreCarrera);
        $this->setPlanEstudios($planEstudios);
    }
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombreCarrera(): string {
        return $this->nombreCarrera;
    }

    public function setNombreCarrera(string $nombreCarrera): void {
        $this->nombreCarrera = $nombreCarrera;
    }

    public function getPlanEstudios(): array {
        return $this->planEstudios;
    }

    public function setPlanEstudios(array $planEstudios): void {
        $this->planEstudios = $planEstudios;
    }
    
    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombreCarrera' => $this->nombreCarrera,
            'planEstudios' => $this->planEstudios
        ];
    }
}

?>