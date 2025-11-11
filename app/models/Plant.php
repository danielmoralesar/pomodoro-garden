<?php

abstract class Plant{
    public function __construct(
        protected string $title,
        protected string $description,
        protected bool $taskCompleted,
        protected string $instanceImage,
        protected int $healthPoints = 100,
        protected string $status = "resting",
    ){}


        /**
         * Get the value of heathPoints
         */ 
        public function getHealthPoints()
        {
                return $this->healthPoints;
        }

        /**
         * Get the value of title
         */ 
        public function getTitle()
        {
                return $this->title;
        }
}