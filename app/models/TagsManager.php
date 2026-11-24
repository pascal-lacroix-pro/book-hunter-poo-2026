<?php

namespace App\Models;

use \Core\DB;
use \PDO;

abstract class TagsManager
{
    public static function findAllByBookId(int $id): array
    {
        $sql = "SELECT t.*
            FROM tags t
            INNER JOIN books_has_tags bht ON bht.tag_id = t.id
            WHERE bht.book_id = :id;";
        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();
        return $rs->fetchAll(PDO::FETCH_CLASS, Tag::class);
    }

    public static function findAll(): array
    {
        $sql = "SELECT *
            FROM tags
            ORDER BY name ASC;";
        $rs = DB::getConnexion()->query($sql);
        return $rs->fetchAll(PDO::FETCH_CLASS, Category::class);
    }
}
