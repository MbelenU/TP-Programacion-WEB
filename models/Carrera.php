<?php
class Carrera {
    private int $id;
    private string $nombreCarrera;
    private array $planDeEstudios; // List<PlanDeEstudio>

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

    public function getPlanDeEstudios(): array {
        return $this->planDeEstudios;
    }

    public function setPlanDeEstudios(array $planDeEstudios): void {
        $this->planDeEstudios = $planDeEstudios;
    }
}

?>