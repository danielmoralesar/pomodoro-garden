<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";

final class HarvestPlant extends Plant{
    
    public function __construct(
        string $title, 
        string $description, 
        string $plantPic,
        private int $deadLine,
        int $plantedDay = 0, 
        PlantState $plantState = PlantState::seed,
        PlantState $previousState = PlantState::initial, 
        bool $taskCompleted = false, 
        int $healthPoints = 100,
        int $id = -1
        ){
        parent::__construct(
            $title, 
            $description, 
            $plantPic, 
            $plantedDay, 
            $plantState,
            $previousState,
            $taskCompleted, 
            $healthPoints,
            $id);
    }

    /**
     * Suma o resta los puntos de salud dependiendo del estado de la tarea. Si la tarea ha sido completada, se sumarán 10 puntos de salud multiplicado por la cantidad de días restantes hasta la fecha límite de la tarea, no se sumarán más puntos si la salud de la planta es igual o mayor a 500 puntos
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
            $this->healthPoints += floor(($this->deadLine - time()) / 86400) +1 * 10;
            $this->healthPoints = $this->healthPoints > 500 ? 500 : $this->healthPoints;
        } else if (time() > $this->deadLine) {
            $this->healthPoints -= floor((time() - $this->deadLine) / 86400)* 10;
        } else {
            $this->healthPoints -= 5;
        }
    }

    public function __tostring(): string{
        if (!$this->taskCompleted){
            $daysTillBeDone = convertSecondsToDays($this->deadLine - time());
            if ($daysTillBeDone < 5){
                $footer = "<p>Quedan <span class=\"text-warning\">$daysTillBeDone</span> para terminar la tarea</p>";
            } else if ($daysTillBeDone < 1){
                $footer = "<p>Quedan <span class=\"text-danger\">$daysTillBeDone</span> para terminar la tarea</p>";
            } else {
                $footer = "<p>Quedan <span class=\"text-info\">$daysTillBeDone</span> para terminar la tarea</p>";
            }
        } else {
            $footer = "<p class=\"text-bg-success\">¡Tarea completada!</p>";
        }

        //TODO crear un botón que cierre la tarea o elimine la planta
        // IDEA: que el botón sea un summit que lleve a terminar/abrir la tarea o eliminar la planta. hacer
        
        return "<div class=\"col-12 col-md-6 col-lg-2\">
            <div class=\"card\">
                ". parent::__tostring() ."
                <div class=\"card-footer\">
                     $footer 
                </div>
            </div>
        </div>";
    }


        /**
         * Get the value of deadLine
         */ 
        public function getDeadLine()
        {
                return $this->deadLine;
        }
}