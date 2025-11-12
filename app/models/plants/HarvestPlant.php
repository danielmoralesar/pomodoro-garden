<?php

final class HarvestPlant extends Plant{
    
    public function __construct(
        string $title, 
        string $description, 
        string $instanceImage, 
        private int $deadLine, 
        bool $taskCompleted = false, 
        int $healthPoints = 100, 
        int $plantedDay = time()
        ){
        parent::__construct($title, $description, $instanceImage, $taskCompleted, $healthPoints, $plantedDay);
    }

    /**
     * Suma o resta los puntos de salud dependiendo del estado de la tarea. Si la tarea ha sido completada, se sumarán 10 puntos de salud multiplicado por la cantidad de días restantes hasta la fecha límite de la tarea, no se sumarán más de 100 puntos de salud a la planta
     * 
     * En caso de que la tarea aún no haya sido completada y haya pasado la fecha límite, se restarán 10 puntos por cada día que pase desde la fecha límite, es decir, si han pasado 2 días de la fecha límite, se restarán 20 puntos.
     * 
     * En caso de que la tarea aún no haya sido completada, se restarán unicamente 10 puntos de salud.
     * 
     * Esta función se aplicará una vez al día hasta que la tarea haya sido completada 
     * @return void
     */
    public function calculateHealthPoints(){
        if ($this->taskCompleted){
            $this->healthPoints += (($this->deadLine - time()) / 86400) * 10;
            $this->healthPoints = $this->healthPoints > 100 ? 100 : $this->healthPoints;
        } else if (time() > $this->deadLine) {
            $this->healthPoints -= ((time() - $this->deadLine) / 86400) * 10;
        } else {
            $this->healthPoints -= 10;
        }
    }
}