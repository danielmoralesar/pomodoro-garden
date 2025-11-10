<?php

final class DecorativePlant extends Plant{
    public function __construct(
        string $title, 
        string $description, 
        bool $taskCompleted, 
        string $instanceImage,
        private string $frecuency,
        private int $currentStreak,
        private int $longestStreak,
        private int $lastTimeWatered,  
        int $heathPoints = 100,
        string $status = 'resting'){
            parent::__construct($title, $description, $taskCompleted, $instanceImage, $heathPoints, $status);
        }

}