<?php

class CoreDB{
    public static function getConn(): mysqli {
        return new mysqli($_ENV['HOSTNAME'], $_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['DB_NAME']);
    }
}