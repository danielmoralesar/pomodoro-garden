<?php

abstract class Task{
    function __construct(
        protected string $title,
        protected string $description,
        protected string $createdAt,
        protected User $assignedUser,
        protected string $deadline,
        protected string $priority,
        protected string $status = "pendient"
    ){}
}