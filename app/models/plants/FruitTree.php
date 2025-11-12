<?php

final class FruitTree extends Plant {
    public function __construct(
        string $title, 
        string $description, 
        string $instanceImage,
        int $plantedDay,
        private int $frecuency,
        private int $nextOcurrence,
        private int $finalOccurrence,
        private array $history,
        private bool $isCycleFinished = false,
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
     * Suma o resta los puntos de salud dependiendo del estado de la tarea. Si la tarea ha sido completada, se sumarán 5 puntos de salud multiplicado por la cantidad de días que se ha cumplido la tarea, no se sumarán más puntos si la salud de la planta es igual o mayor a 100 puntos
     * 
     * En caso de que la tarea aún no haya sido completada y haya pasado la fecha límite, se restarán 10 puntos por cada día que pase desde la fecha límite, es decir, si han pasado 2 días de la fecha límite, se restarán 20 puntos.
     * 
     * En caso de que la tarea aún no haya sido completada, se restarán unicamente 10 puntos de salud.
     * 
     * Esta función se aplicará una vez al día hasta que haya pasado la ultima ocurrencia
     * @return void
     */
    final public function calculateHealthPoints(){
        if ($this->taskCompleted) {
            $this->healthPoints += count($this->history) * 5;
            $this->healthPoints = $this->healthPoints > 100 ? 100 : $this->healthPoints;
        } else if (time() > $this->nextOcurrence){
            $this->healthPoints -= floor(($this->nextOcurrence - time()) / 86400) * -10;
        } else {
            $this->healthPoints -= 10;
        }
    }

    final public function completeOrReopenTask(bool $isCompleted): void
    {
        if($isCompleted){
            $this->history[] = time();
            $this->nextOcurrence += $this->frecuency;
            if($this->nextOcurrence > $this->finalOccurrence){
                $this->isCycleFinished = true;
            }
        }
        parent::completeOrReopenTask($isCompleted);
    }
}
