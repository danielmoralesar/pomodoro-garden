<?php

final class DecorativePlant extends Plant{
    public function __construct(
        string $title, 
        string $description,  
        string $instanceImage,
        private string $frecuency,
        private int $currentStreak,
        private int $longestStreak,
        private int $lastTimeCompleted,
        bool $taskCompleted = false, 
        int $healthPoints = 100, 
        int $plantedDay = time()
        ){
            parent::__construct($title, $description, $instanceImage, $taskCompleted, $healthPoints, $plantedDay);
        }

    public function calculateHealthPoints(){
        if ($this->taskCompleted) {
            $this->healthPoints += ($this->currentStreak == $this->longestStreak ? $this->currentStreak * 20 : $this->currentStreak )* 2;
            $this->longestStreak = $this->currentStreak == $this->longestStreak ? $this->currentStreak : $this->longestStreak;
            $this->healthPoints = $this->healthPoints > 100 ? 100 : $this->healthPoints;
        } else if (strtotime("now") < $this->lastTimeCompleted){
            $this->healthPoints -= (($this->lastTimeCompleted - strtotime("now")) * -10) / 86400;
        } else {
            
        }
    }
}