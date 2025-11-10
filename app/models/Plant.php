<?php

abstract class Plant{
    public function __construct(
        protected string $title,
        protected string $description,
        protected int $heathPoints,
        protected string $status, 
        protected string $species,
        protected bool $taskCompleted,
        protected string $instanceImage
    ){}

    abstract public static function createPlant();
}