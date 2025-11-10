<?php

class User{
    public function __construct(
        private string $userName,
        private string $password,
        private string $email,
        private array $gardens = []
    ){}
}