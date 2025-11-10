<?php

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php";
include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Plant.php";

class Garden {
    public function __construct(
        private string $title,
        private User $owner,
        private string $environment,
        private array $plants = []
    ){}
}