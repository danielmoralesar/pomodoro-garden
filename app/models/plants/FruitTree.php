<?php

final class FruitTree extends Plant {
    public function __construct(
        string $title, 
        string $description, 
        string $instanceImage,
        private string $frecuency,
        private int $nextOcurrence,
        private int $lastOccurrence,
        private array $history,
        bool $taskCompleted = false,  
        int $healthPoints = 100,
        int $plantedDay = time()
        ){
            parent::__construct($title, $description, $instanceImage, $taskCompleted, $healthPoints, $plantedDay);
        }
    
    public function calculateHealthPoints(){
        if ($this->taskCompleted) {
            $this->healthPoints += count($this->history) * 5;
            $this->healthPoints = $this->healthPoints > 100 ? 100 : $this->healthPoints;
        } else if (strtotime("now") > $this->nextOcurrence){
            $this->healthPoints -= (($this->nextOcurrence - strtotime("now")) / 86400) * -10;
        }
    }
}
