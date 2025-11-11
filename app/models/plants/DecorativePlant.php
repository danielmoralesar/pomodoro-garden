<?php

final class DecorativePlant extends Plant{
    public function __construct(
        string $title, 
        string $description,  
        string $instanceImage,
        private string $frecuency,
        private int $currentStreak,
        private int $longestStreak,
        private int $lastTimeWatered,
        bool $taskCompleted = false,  
        int $healthPoints = 100,
        ){
            parent::__construct($title, $description, $instanceImage, $taskCompleted, $healthPoints);
        }

    public function calculateHealthPoints(){
        if ($this->taskCompleted) {
            $this->healthPoints += $this->currentStreak * 5;
            $this->healthPoints = $this->healthPoints > 100 ? 100 : $this->healthPoints;
        } else if (strtotime("now") < $this->lastTimeWatered){
            $this->healthPoints -= (($this->lastTimeWatered - strtotime("now")) / 86400) * -10;
        } else {
            
        }
    }
}