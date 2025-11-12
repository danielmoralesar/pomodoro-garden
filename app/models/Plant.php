<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/HarvestPlant.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/FruitTree.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/DecorativePlant.php";

abstract class Plant{
    public function __construct(
        protected string $title,
        protected string $description,
        protected string $instanceImage,
        protected int $plantedDay,
        protected bool $taskCompleted = false,
        protected int $healthPoints = 100,
    ){}
 
    
    public function completeOrReopenTask(bool $isCompleted): void{
        $this->taskCompleted = $isCompleted;
    }

    /**
     * De momento las plantas van a obtener puntos de salud si se completan
     * las tareas, si no se completan, van a peder cada ves más puntos de salud
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
}