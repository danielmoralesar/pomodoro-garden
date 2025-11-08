<?php

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Task.php";

class Plant{
    public function __construct(
        private array $tasks,
        private string $type,
        private string $deadline,
        private int $growRate,
        private string $healthStatus,
        private string $urgencyLevel,
        private int $healthPoints = 100,
        private string $stage = "seed"
    ){}
}