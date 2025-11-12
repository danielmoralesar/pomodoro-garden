<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/HarvestPlant.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/FruitTree.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/plants/DecorativePlant.php";

abstract class Plant{
    public function __construct(
        protected string $title,
        protected string $description,
        protected string $instanceImage,
        protected bool $taskCompleted = false,
        protected int $healthPoints = 100,
        protected int $plantedDay = time()
    ){}
 
    /**
     * Complete or Re-open a task, if the task is complete, set it true, else, set it false
     * @param bool $bool
     * @return void
     */
    public function completeOrReopenTask(bool $bool){
        $this->taskCompleted = $bool;
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