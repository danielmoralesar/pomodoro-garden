<?php

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";


class Garden{
    public function __construct(
        private User $owner,
        private string $enviroment,
        private array $gardeners = [],
        private array $plants = [],
    ){}

    /**
     * Get the value of owner
     */ 
    public function getOwner()
    {
            return $this->owner;
    }
}