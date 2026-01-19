<?php

class CoreDB{
    public static function getConn(): mysqli {
        return new mysqli("127.0.0.1", "root", "Sandia4you", "PomodoroGardenDB");
    }
}