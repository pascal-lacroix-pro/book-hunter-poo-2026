<?php

namespace App\Models;

use \Core\DB;
use \PDO;

abstract class CategoriesManager
{
    public static function findOneById(int $id): Category
    {
        $sql = "SELECT *
            FROM categories
            WHERE id = :id;";
        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();
        return $rs->fetchObject(Category::class);
    }

    public static function findAll(): array
    {
        $sql = "SELECT *
            FROM categories
            ORDER BY name ASC;";
        $rs = DB::getConnexion()->query($sql);
        return $rs->fetchAll(PDO::FETCH_CLASS, Category::class);
    }
}
