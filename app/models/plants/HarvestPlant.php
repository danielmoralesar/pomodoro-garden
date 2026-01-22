<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";

final class HarvestPlant extends Plant{
    
    public function __construct(
        string $title, 
        string $description, 
        private int $deadLine,
        string $plantPic = "/resources/assets/silencePrincess.jpg",
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
                $footer = "<p>Quedan <span class=\"text-warning\">$daysTillBeDone</span> día(s) para terminar la tarea</p>";
            } else if ($daysTillBeDone < 1){
                $footer = "<p>Quedan <span class=\"text-danger\">$daysTillBeDone</span> día(s) para terminar la tarea</p>";
            } else {
                $footer = "<p>Quedan <span class=\"text-info\">$daysTillBeDone</span> día(s) para terminar la tarea</p>";
            }
        } else {
            $footer = "<p class=\"text-bg-success\">¡Tarea completada!</p>";
        }

        $openOrCloseTaskBtn = $this->taskCompleted ? "Abrir" : "Terminar";
        
        return "<div class=\"col-12 col-md-6 col-lg-2\">
            <div class=\"card card-fixed\">
                ". parent::__tostring() ."
                <div class=\"card-footer\">
                    $footer
                    <button href=\"plants.php\" class=\"btn btn-sm btn-danger\" style=\"max-height: 50px\" data-bs-toggle=\"modal\" data-bs-target=\"#{$this->id}\">
                        Borrar Planta
                    </button>
                    <form method=\"post\" action=\"plants.php\" style=\"display: inline;\">
                        <input href=\"plants.php\" type=\"hidden\" name=\"plantIdTask\" value=\"{$this->id}\">
                        <input value=\"$openOrCloseTaskBtn tarea\" type=\"submit\" name=\"completeOrOpenTask\" class=\"btn btn-sm btn-success mt-1\" style=\"max-height: 50px\">
                    </form>
                </div>
            </div>
        </div>
        
        <div class=\"modal fade\" id=\"{$this->id}\" tabindex=\"-1\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\">¿Seguro que quieres borrar esta planta?</h5>
                    <button class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Cerrar\"></button>
                </div>
                <div class=\"modal-body\">
                    <p class=\"text-muted\">Perderás tu planta para siempre.</p>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">
                        Cancelar
                    </button>
                    <form method=\"post\" action=\"plants.php\" style=\"display: inline;\">
                        <input type=\"hidden\" name=\"plantIdDelete\" value=\"{$this->id}\">
                        <input value=\"Borrar Planta\" type=\"submit\" name=\"delete\" class=\"btn btn-danger\">
                    </form>
                </div>
            </div>
        </div>
    </div>";
    }

    public function getDeadLine()
    {
            return $this->deadLine;
    }

}