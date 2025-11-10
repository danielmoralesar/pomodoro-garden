<?php

abstract class Plant{
    public function __construct(
        protected string $title,
        protected string $description,
        protected bool $taskCompleted,
        protected string $instanceImage,
        protected int $heathPoints = 100,
        protected string $status = "resting",
    ){}

}