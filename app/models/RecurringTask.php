<?php

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Task.php";

class RecurringTask extends Task
{
    function __construct(
        private string $frecuency,
        private string $nextOccurrence,
        private array $history,
        string $title, 
        string $description, 
        string $createdAt, 
        User $assignedUser, 
        string $deadline, 
        string $priority, 
        string $status = 'pendient')
    {
        parent::__construct($title, $description, $createdAt, $assignedUser, $deadline, $priority, $status);
    }
}