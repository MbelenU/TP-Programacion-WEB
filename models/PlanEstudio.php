<?php

class PlanEstudio {
    private int $id;
    private string $nombrePlanEstudio;
    private array $materia;
    public function __construct(int $id, string $nombrePlanEstudio) {
        $this->setId($id);
        $this->setNombrePlanEstudio($nombrePlanEstudio);
    }
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
    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombrePlanEstudio' => $this->nombrePlanEstudio
        ];
    }
}
?>