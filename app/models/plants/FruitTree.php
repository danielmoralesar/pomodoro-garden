<?php

final class FruitTree extends Plant {
    public function __construct(
        string $title, 
        string $description, 
        int $heathPoints, 
        string $status, 
        string $species, 
        bool $taskCompleted, 
        string $instanceImage,
        private string $frecuency,
        private int $nextOcurrence,
        private int $lastOccurrence,
        private array $history
        ){
            parent::__construct(
                $title, $description, $heathPoints, $status, $species, $taskCompleted, $instanceImage);
        }

    public static function createPlant()
    {
        
    }
}
