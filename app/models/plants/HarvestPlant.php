<?php

final class HarvestPlant extends Plant{
    public function __construct(
        string $title, 
        string $description, 
        bool $taskCompleted, 
        string $instanceImage,
        private int $deadline, 
        int $heathPoints = 100,
        string $status = 'resting'){
            parent::__construct($title, $description, $taskCompleted, $instanceImage, $heathPoints, $status);
        }

}