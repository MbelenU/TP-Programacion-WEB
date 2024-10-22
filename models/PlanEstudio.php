<?php

class PlanEstudio {
    private int $id;
    private string $nombrePlanEstudio;
    private array $materia; // List<Materia>

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNombrePlanEstudio(): string {
        return $this->nombrePlanEstudio;
    }

    public function setNombrePlanEstudio(string $nombrePlanEstudio): void {
        $this->nombrePlanEstudio = $nombrePlanEstudio;
    }

    public function getMateria(): array {
        return $this->materia;
    }

    public function setMateria(array $materia): void {
        $this->materia = $materia;
    }
}
?>