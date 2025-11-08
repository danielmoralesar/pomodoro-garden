<?php

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Task.php";

class SimpleTask extends Task
{
    function __construct(string $title, string $description, string $createdAt, User $assignedUser, string $deadline, string $priority, string $status = 'pendient')
    {
        parent::__construct($title, $description, $createdAt, $assignedUser, $deadline, $priority, $status);
    }
}