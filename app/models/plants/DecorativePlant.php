<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";

final class DecorativePlant extends Plant{
    public function __construct(
        string $title, 
        string $description,  
        string $instanceImage,
        int $plantedDay,
        private int $frecuency,
        private int $nextOcurrence,
        private int $currentStreak = 0,
        private int $longestStreak = 0,
        private int $lastTimeCompleted = 0,
        PlantState $plantState = PlantState::seed,
        PlantState $previousState = PlantState::initial,
        bool $taskCompleted = false, 
        int $healthPoints = 100, 
        ){
        parent::__construct(
            $title, 
            $description, 
            $instanceImage, 
            $plantedDay, 
            $plantState,
            $previousState,
            $taskCompleted, 
            $healthPoints);
    }

    /**
     * Suma o resta los puntos de salud dependiendo del estado de la tarea. Si la tarea ha sido completada, se sumarán 5 puntos de salud multiplicado por la racha, si la racha de hoy ha superado la anterior, se premia con 30 puntos más, no se sumarán más puntos si la salud de la planta es igual o mayor a 500 puntos
     * 
     * En caso de que la tarea aún no haya sido completada y haya pasado la fecha límite, se restarán 10 puntos por cada día que pase desde la fecha límite, es decir, si han pasado 2 días de la fecha límite, se restarán 20 puntos.
     * 
     * En caso de que la tarea aún no haya sido completada, se restarán unicamente 15 puntos de salud.
     * 
     * Esta función se aplicará una vez al día hasta que haya pasado la ultima ocurrencia
     * @return void
     */
    public function calculateHealthPoints(){
        if ($this->taskCompleted) {
            $this->healthPoints += $this->currentStreak * 5;

            $this->longestStreak = 
                $this->currentStreak > $this->longestStreak ? 
                    $this->currentStreak : $this->longestStreak;

            $this->healthPoints = $this->healthPoints > 500 ? 500 : $this->healthPoints;
            
        } else if (strtotime("now") < $this->nextOcurrence){
            $this->healthPoints -= floor((($this->lastTimeCompleted - strtotime("now")) / 86400) * -10);
        } else {
            $this->healthPoints -= 15;
        }
    }

    final public function completeOrReopenTask(bool $isCompleted): void
    {
        if($isCompleted){
            ++$this->currentStreak;
            $this->lastTimeCompleted = time();
            $this->nextOcurrence = time() + $this->frecuency;
            $this->calculateHealthPoints();
        }
        parent::completeOrReopenTask($isCompleted);
    }

    public function __tostring()
    {
        $streak = $this->currentStreak == 0 ? " No hay racha de momento" : date("d", $this->currentStreak) . " días";
        $record = $this->longestStreak == 0 ? " No hay record de momento" : date("d", $this->longestStreak) . " días";
        $lastTimeCompleted = $this->lastTimeCompleted == 0 ? " No se ha comenzado con este hábito aún" : date("d-m-Y", $this->lastTimeCompleted);
        return printForHtml(parent::__tostring() .
            printForHtml("Planta de tipo: decorativa (para crear hábitos)", "li") .
            printForHtml("Frecuencia del hábito: cada " . date("d", $this->frecuency) . " días", "li") . 
            printForHtml("Racha actual: $streak", "li") . 
            printForHtml("Récord de racha: " . $record, "li") . 
            printForHtml("Última vez que se ha completado el hábito: " . $lastTimeCompleted, "li")
            . "</ul>", "div", "class","object");
    }
}

