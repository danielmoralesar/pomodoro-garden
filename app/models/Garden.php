<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";

class Garden {
    public function __construct(
        private string $title,
        private User $owner,
        private string $environment,
        private array $plants = [],
        private array $witheredPlants = []
    ){}

    /**
     * Adds a plant to the garden, plants in a garden must have different names
     * @param Plant $plant
     * @return bool if there's already a plant with the same title, returs false, else returns true
     */
    public function addPlant(Plant $plant): bool{
        if (!in_array($plant, $this->plants)){
            $this->plants[] = $plant;
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

    /**
     * Look for unattended plants and takes them to the witheredPlants array
     * @return void
     */
    public function findwitheredPlants(): void{
        foreach ($this->plants as $plant) {
            if ($plant->getHealthPoints() <= 0){
                array_push($this->witheredPlants, $plant);
                array_slice($this->plants, in_array($plant, $this->plants), 1);
            }
        }
    }

    /**
     * Summary of clearDeadPlant
     * @return void
     */
    public function clearDeadPlant(): void{
        echo printForHtml("Se han encontrado " . count($this->witheredPlants) . " plantas muerta, se procederá a limpiarlas del jardín");
        $this->witheredPlants = [];
    }

    public function changeEnvironment($newEnvironment): void{
        $this->environment = $newEnvironment;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function __tostring(): string{
        $plants = printForHtml("Plantas del Jardín") . (count($this->plants) < 1 ? printForHtml(" no hay plantas en el jardín ") : printArray($this->plants));
        $witheredPlants = printForHtml("Plantas marchitas: ") . (count($this->witheredPlants) < 1 ? printForHtml(" no hay plantas marchitas en el jardín ") : printArray($this->witheredPlants));
        return
            printForHtml(printForHtml("Titulo del Jardín: {$this->title}; User: {$this->owner->getUserName()}; Environment(Fondo): {$this->environment}") . $plants . $witheredPlants, "div", "class", "object");
    }


    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}