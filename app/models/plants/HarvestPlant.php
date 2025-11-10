<?php

final class HarvestPlant extends Plant{
    public function __construct(
        string $title, 
        string $description, 
        int $heathPoints, 
        string $status, 
        string $species, 
        bool $taskCompleted, 
        string $instanceImage,
        private int $deadline
        ){
            parent::__construct(
                $title, $description, $heathPoints, $status, $species, $taskCompleted, $instanceImage);
        }
}