<?php

final class HarvestPlant extends Plant{
    public function __construct(
        string $title, 
        string $description,
        string $instanceImage,
        private int $deadLine,
        bool $taskCompleted = false, 
        int $healthPoints = 100){
            parent::__construct($title, $description, $instanceImage, $taskCompleted, $healthPoints);
        }

    public function calculateHealthPoints(){
        if ($this->taskCompleted){
            $this->healthPoints += 20;
            $this->healthPoints = $this->healthPoints > 100 ? 100 : $this->healthPoints;
        } else if (strtotime("now") > $this->deadLine) {
            //TODO explain this tomorrow at doc
            $this->healthPoints -= (($this->deadLine - strtotime("now")) / 86400) * -10 ;
        }
    }
}