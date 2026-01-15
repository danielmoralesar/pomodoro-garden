<?php

class CoreDB{
    public static function getConn(): mysqli {
        return new mysqli("localhost", "root", "Sandia4you", "PomodoroGardenDB");
    }
}