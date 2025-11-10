<?php

final class DecorativePlant extends Plant{
    public function __construct(
        string $title, 
        string $description, 
        int $heathPoints, 
        string $status, 
        string $species, 
        bool $taskCompleted, 
        string $instanceImage,
        private string $frecuency,
        private int $currentStreak,
        private int $longestStreak,
        private int $lastTimeWatered
        ){
            parent::__construct(
                $title, $description, $heathPoints, $status, $species, $taskCompleted, $instanceImage);
        }

    public static function createPlant()
    {
        
    }
}