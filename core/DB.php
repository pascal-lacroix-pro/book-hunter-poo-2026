<?php

namespace Core;

use \PDO;
use \PDOException;

abstract class DB
{
    public static function getConnexion()
    {
        try {
            return new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PWD);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
