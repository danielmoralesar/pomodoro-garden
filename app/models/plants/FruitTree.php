<?php

final class FruitTree extends Plant {
    public function __construct(
        string $title, 
        string $description, 
        bool $taskCompleted, 
        string $instanceImage,
        private string $frecuency,
        private int $nextOcurrence,
        private int $lastOccurrence,
        private array $history,
        int $heathPoints = 100,
        string $status = 'resting'
        ){
            parent::__construct($title, $description, $taskCompleted, $instanceImage, $heathPoints, $status);
        }

}
