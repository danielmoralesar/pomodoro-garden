<?php

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Garden.php";

class User{
    public function __construct(
        private string $userName,
        private string $password,
        private string $email,
        private array $gardens
    ){}
}