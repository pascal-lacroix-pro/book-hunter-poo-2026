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

    public static function findOneById(int $id): Book
    {
        $sql = "SELECT b.*, ROUND(AVG(us.note), 2) AS notation
                FROM books b
                LEFT JOIN users_notations us ON us.book_id = b.id
                WHERE b.id = :id;";
        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();
        return $rs->fetchObject(Book::class);
    }

    public static function findAllByAuthorId(int $id): array
    {
        $sql = "SELECT *
                FROM books
                WHERE author_id = :id
                ORDER BY publicated_at DESC;";
        $rs = DB::getConnexion()->prepare($sql);
        $rs->bindValue(':id', $id, PDO::PARAM_INT);
        $rs->execute();
        return $rs->fetchAll(PDO::FETCH_CLASS, Book::class);
    }
}
