<?php


include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";

class Garden {
    public function __construct(
        private string $title,
        private User $owner,
        private string $environment,
        private array $plants = [],
        private array $deadPlants = []
    ){}

    public function addPlant(Plant $plant): bool{
        // recibe una planta ya creada y la mete en el array
        if (!in_array($plant, $this->plants)){
            array_push($this->plants, $plant);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Search for a plant in the garden
     * @param string $plantTitle the plant title
     * @return Plant|bool if exists, returns the plant, else, returns false
     */
    public function findPlant(string $plantTitle): Plant | bool{
        return findSomethingByTitle($plantTitle, $this->plants);
    }

    public function findDeadPlants(): void{
        foreach ($this->plants as $plant) {
            if ($plant->getHealthPoints() <= 0){
                array_push($this->deadPlants, $plant);
                array_slice($this->plants, in_array($plant, $this->plants), 1);
            }
        }
    }

    public function clearDeadPlant(): void{
        echo printForHtml("Se han encontrado " . count($this->deadPlants) . " plantas muerta, se procederá a limpiarlas del jardín");
        $this->deadPlants = [];
    }

    public function changeEnvironment($newEnvironment): void{
        $this->environment = $newEnvironment;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function __tostring(): string{
        $plants = "";
        foreach ($this->plants as $plant) {
            $plants .= $plant->getTitle() . ", ";
        }
        return "{$this->title}, {$this->owner->getUserName()}, {$this->environment}, $plant";
    }
}