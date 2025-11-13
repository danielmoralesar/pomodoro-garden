<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";

final class HarvestPlant extends Plant{
    
    public function __construct(
        string $title, 
        string $description, 
        string $instanceImage,
        int $plantedDay, 
        private int $deadLine, 
        bool $taskCompleted = false, 
        int $healthPoints = 100, 
        ){
        parent::__construct(
            $title, 
            $description, 
            $instanceImage, 
            $plantedDay, 
            $taskCompleted, 
            $healthPoints);
    }

    /**
     * Suma o resta los puntos de salud dependiendo del estado de la tarea. Si la tarea ha sido completada, se sumarán 10 puntos de salud multiplicado por la cantidad de días restantes hasta la fecha límite de la tarea, no se sumarán más puntos si la salud de la planta es igual o mayor a 100 puntos
     * 
     * En caso de que la tarea aún no haya sido completada y haya pasado la fecha límite, se restarán 10 puntos por cada día que pase desde la fecha límite, es decir, si han pasado 2 días de la fecha límite, se restarán 20 puntos.
     * 
     * En caso de que la tarea aún no haya sido completada, se restarán unicamente 5 puntos de salud.
     * 
     * Esta función se aplicará una vez al día hasta que la tarea haya sido completada 
     * @return void
     */
    final public function calculateHealthPoints(){
        if ($this->taskCompleted){
            $this->healthPoints += floor(($this->deadLine - time()) / 86400) * 10;
            $this->healthPoints = $this->healthPoints > 100 ? 100 : $this->healthPoints;
        } else if (time() > $this->deadLine) {
            $this->healthPoints -= floor((time() - $this->deadLine) / 86400)* 10;
        } else {
            $this->healthPoints -= 5;
        }
    }

    public function __tostring(){
        return parent::__tostring() . 
            printForHtml("Planta de tipo: cosechable (tareas que solo se deben hacer una vez)", "li") . 
            printForHtml("Fecha límite: " . date("d-m-Y", $this->deadLine), "li") . "</ul>";
    }
}