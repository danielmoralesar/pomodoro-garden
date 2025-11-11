<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/utils/functions.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";

class Garden {
    public function __construct(
        private string $title,
        private User $owner,
        private string $environment,
        private array $plants = [],
        private array $deadPlants = []
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
     * Look for unattended plants and takes them to the deadPlants array
     * @return void
     */
    public function findDeadPlants(): void{
        foreach ($this->plants as $plant) {
            if ($plant->getHealthPoints() <= 0){
                array_push($this->deadPlants, $plant);
                array_slice($this->plants, in_array($plant, $this->plants), 1);
            }
        }
    }

    /**
     * Summary of clearDeadPlant
     * @return void
     */
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
        return
            printForHtml(
                "Jardín (Queaseres agrupados) titulado " . $this->title . " de " . $this->owner->getUserName() 
            ) . 
            printForHtml("Plantas vivas (Quehaceres): ") . printArray($this->plants);
        // $plants = "";
        // foreach ($this->plants as $plant) {
        //     $plants .= $plant->getTitle() . ", ";
        // }
        // return "{$this->title}, {$this->owner->getUserName()}, {$this->environment}, $plant";
    }
}