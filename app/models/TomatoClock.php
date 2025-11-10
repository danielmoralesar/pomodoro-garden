<?php

class TomatoClock{
    public function __construct(
        private string $fase,
        private string $state,
        private Plant $workingPlant,
        private int $completedRests = 0,
        private int $remaningTime = 1500
    ){}
}