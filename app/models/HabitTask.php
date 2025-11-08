<?php

include $_SERVER['DOCUMENT_ROOT'] . "/app/models/Task.php";

class HabitTask extends Task
{
    function __construct(
        private string $frecuency,
        private int $currentStreak,
        private int $longestStreak,
        private string $lastCompleted,
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