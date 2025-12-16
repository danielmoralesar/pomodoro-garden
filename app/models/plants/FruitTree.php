<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";

final class FruitTree extends Plant {
    public function __construct(
        string $title, 
        string $description, 
        string $instanceImage,
        int $plantedDay,
        private int $frecuency,
        private int $nextOcurrence,
        private int $finalOccurrence,
        private array $history = [],
        private bool $isCycleFinished = false,
        PlantState $plantState = PlantState::seed,
        bool $taskCompleted = false, 
        int $healthPoints = 100, 
        ){
        parent::__construct(
            $title, 
            $description, 
            $instanceImage, 
            $plantedDay,
            $plantState, 
            $taskCompleted, 
            $healthPoints);
    }
    
    /**
     * Suma o resta los puntos de salud dependiendo del estado de la tarea. Si la tarea ha sido completada, se sumarán 5 puntos de salud multiplicado por la cantidad de días que se ha cumplido la tarea, si el ciclo de tareas ha terminado, se recompensará adicionalmente con 20 puntos. 
     * 
     * No se sumarán más puntos si la salud de la planta es igual o mayor a 500 puntos
     * 
     * En caso de que la tarea aún no haya sido completada y además haya pasado la fecha límite, se restarán 10 puntos por cada día que pase desde la fecha límite, es decir, si han pasado 2 días de la fecha límite, se restarán 20 puntos.
     * 
     * En caso de que la tarea aún no haya sido completada, se restarán unicamente 10 puntos de salud.
     * 
     * Esta función se aplicará una vez al día hasta que haya pasado la ultima ocurrencia
     * @return void
     */
    final public function calculateHealthPoints(){
        if ($this->taskCompleted) {
            $this->healthPoints += count($this->history) * 5 + $this->isCycleFinished ? 20 : 0 ;
            $this->healthPoints = $this->healthPoints > 500 ? 500 : $this->healthPoints;
        } else if (time() > $this->nextOcurrence){
            $this->healthPoints -= floor(($this->nextOcurrence - time()) / 86400) * -10;
        } else {
            $this->healthPoints -= 10;
        }
    }

    /**
     * Si se completa la tarea, se recalculará la siguiente fecha límite de la tarea, si en el cálculo se ha sobrepasado la última fecha de entrega, se dará por terminada la tarea
     * @param bool $isCompleted
     * @return void
     */
    final public function completeOrReopenTask(bool $isCompleted): void
    {
        if($isCompleted){
            $this->history[] = time();
            $this->nextOcurrence += $this->frecuency;
            if($this->nextOcurrence > $this->finalOccurrence){
                $this->isCycleFinished = true;
            }
            $this->calculateHealthPoints();
        }
        parent::completeOrReopenTask($isCompleted);
    }

    public function __tostring(){
        return printForHtml(parent::__tostring() . 
            printForHtml("Planta de tipo: arbol frutal (para tareas que se tienen que ir repitiendo durante un periodo de tiempo)", "li") . 
            printForHtml("Frecuencia de repetición: cada " . date("d",$this->frecuency) . " días", "li") . 
            printForHtml("Próxima ocurrencia: " . date("d-m-Y",$this->nextOcurrence), "li") . 
            printForHtml("Ocurrencia Final: " . date("d-m-Y", $this->finalOccurrence), "li") . 
            printForHtml("Historial de días que se ha cumplido la tarea", "li") .
            printDatesArray($this->history) . "</ul>", "div", "class","object");
    }
}

