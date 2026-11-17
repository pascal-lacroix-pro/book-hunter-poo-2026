<?php

namespace App\Models;

use \Core\DB;
use \PDO;

abstract class BooksManager
{
    public static function findAll(int $limit = 9): array
    {
        $sql = "SELECT b.*, ROUND(AVG(us.note), 2) AS notation
                FROM books b
                LEFT JOIN users_notations us ON us.book_id = b.id
                GROUP BY b.id
                ORDER BY notation DESC
                LIMIT :limit;";
        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
        $rs->execute();
        return $rs->fetchAll(PDO::FETCH_CLASS, Book::class);
    }
}
