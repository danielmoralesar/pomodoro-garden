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
     * Cambia el título de un jardín, verifica primero si el jardín existe y además si el nuevo nombre está disponible, en caso de que no se cumplan alguna de las dos condiciones, se devolverá falso
     * @param string $oldTitle 
     * @param string $newTitle 
     * @return bool
     */
    public function changePlantTitle(string $oldTitle, string $newTitle){
        if($this->findPlant($oldTitle) && !$this->findPlant($newTitle)){
            foreach ($this->plants as $plant) {
                if ($plant->getTitle() == $oldTitle){
                    $plant->setTitle($newTitle);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Verifica si existe la planta por su nombre
     * @param string $plantTitle
     * @return bool
     */
    public function plantExist(string $plantTitle):bool{
        foreach ($this->plants as $plants) {
            if ($plantTitle == $plants->getTitle()){
                return true;
            }
        }
        return false;
    }

    /**
     * Busca y devuelve una planta por su títutlo, sino, devuelve false
     * @param string $plantTitle
     * @return Plant|bool
     */
    public function findPlant(string $plantTitle): Plant | bool{
        return findSomethingByTitle($plantTitle, $this->plants);
    }

    /**
     * Busca plantas marchitas (tareas que se le han pasado la fecha límite)
     * @return void
     */
    public function findWitheredPlants(): void{
        $alivePlants = [];
        foreach ($this->plants as $plant) {
            if ($plant->getHealthPoints() <= 0){
                array_push($this->witheredPlants, $plant);
            } else {
                array_push($alivePlants, $plant);
            }
        }
        
        $this->plants = $alivePlants;
    }

    /**
     * Elimina una planta
     * 
     * Si la operación fue exitosa, devuelve true, sino, false
     * @param string $plantTitle
     * @return bool
     */
    public function deletePlant(string $plantTitle){
        $plant = $this->findPlant($plantTitle);
        if ($plant){
            echo printForHtml("Eliminando Planta...");
            array_splice($this->plants, array_search($plant, $this->plants), 1);
            return !$this->plantExist($plantTitle) ? true : false;
        } else {
            return false;
        }
    }

    /**
     * Elimina todas las plantas marchitas
     * @return void
     */
    public function clearWitheredPlants(): void{
        echo printForHtml("Se ha(n) encontrado " . count($this->witheredPlants) . " plantas muerta(s), se procederá a limpiarlas del jardín");
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
        return printForHtml(
            printForHtml("Jardín titulado: {$this->title}", "h4") . "<ul>" .
            printForHtml("Propiedad de {$this->owner->getUserName()}", "li") .
            printForHtml("Plantas del Jardín:", "li") . (count($this->plants) < 1 ? printForHtml(printForHtml(" no hay plantas en el jardín ", "li"), "ul") : printObjectArray($this->plants)) .
            printForHtml(
                "Plantas marchitas:", "li") . 
                (count($this->witheredPlants) < 1 ? 
                printForHtml(
                    printForHtml(
                        "No hay plantas marchitas en el jardín", 
                        "li"), 
                    "ul") : 
                printObjectArray($this->witheredPlants)) .
            "</ul>" .
            printForHtml("<img src='{$this->environment}' alt='{$this->title}' class='environmet-background'>", "div", "class", "img-container"), 
            "div", "class", "object");
    }


    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getPlants()
    {
        return $this->plants;
    }
}