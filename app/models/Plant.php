<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/PlantState.php";

abstract class Plant{
    public function __construct(
        protected string $title,
        protected string $description,
        protected string $plantPic,
        protected int $plantedDay = 0,
        protected PlantState $plantState = PlantState::seed,
        protected PlantState $previousState = PlantState::initial,
        protected bool $taskCompleted = false,
        protected int $healthPoints = 100,
        protected int $id = -1
    ){
        $this->plantedDay = time();
    }
 
    /**
     * Cerrar o volver a abrir una tarea
     * @param bool $isCompleted true para cerrar la tarea, false para abrirla
     * @return void
     */
    public function completeOrReopenTask(bool $isCompleted): void{
        $this->taskCompleted = $isCompleted;
    }

    public function checkPlantState() {
        if ($this->healthPoints < 99 && $this->healthPoints > 0 && $this->plantState != PlantState::withering) {
            $this->previousState = $this->plantState;
            $this->plantState = PlantState::withering;
        } else if ($this->healthPoints <= 0){
            $this->previousState = $this->plantState;
            $this->plantState = PlantState::withered;
        } else {
            if ($this->healthPoints < 200 && $this->healthPoints > 100 && $this->plantState->value == "seed") {
                $this->previousState = $this->plantState;
                $this->plantState = PlantState::sprout;
            } else if ($this->healthPoints < 300 && $this->healthPoints > 200 && $this->plantState->value == "sprout"){
                $this->previousState = $this->plantState;
                $this->plantState = PlantState::seedling;
            } else if ($this->healthPoints < 400 && $this->healthPoints > 300 && $this->plantState->value == "floweing"){
                $this->previousState = $this->plantState;
                $this->plantState = PlantState::flowering;
            }
        }
    }

    /**
     * De momento las plantas van a obtener puntos de salud si se completan
     * las tareas, si no se completan, van a perder cada ves más puntos de salud
     * si se dejan de lado, el cálculo se explica en cada uno de los objetos heredados
     * @return void
     */
    abstract public function calculateHealthPoints();

    public function getHealthPoints()
    {
        return $this->healthPoints;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function __tostring(){
        return 
        printForHtml("Título de la planta: {$this->title} - {$this->id}", "h4") . 
        printForHtml("<img src=\"{$this->plantPic}\" alt='{$this->title}' class='plant-img'>", "div", "class", "img-container") . " <ul>" . 
        printForHtml(" Descripción: {$this->description}", "li"). 
        printForHtml("PS: {$this->healthPoints}", "li") . 
        printForHtml("Estado actual: {$this->getPlantStateAsString()}", "li") .
        printForHtml("Fecha de creación: " . date("d-m-Y", $this->plantedDay), "li") .  
        printForHtml("¿Completada?: " . ($this->taskCompleted ?"si" : "no"), "li");
    }

    public function getTaskCompleted()
    {
        return $this->taskCompleted;
    }

    public function getPlantStateAsString()
    {
            return $this->plantState->value;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
            return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Get the value of plantPic
         */ 
        public function getPlantPic()
        {
                return $this->plantPic;
        }

        /**
         * Get the value of plantedDay
         */ 
        public function getPlantedDay()
        {
                return $this->plantedDay;
        }

        /**
         * Get the value of previousState
         */ 
        public function getPreviousStateAsString()
        {
                return $this->previousState->value;
        }
}