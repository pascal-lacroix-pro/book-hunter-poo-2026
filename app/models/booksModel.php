<?php

namespace App\Models\BooksModel;

use \PDO;

function findAll(PDO $connexion, int $limit = 9): array
{
    $sql = "SELECT *
            FROM books
            ORDER BY created_at DESC
            LIMIT :limit;";
    $rs = $connexion->prepare($sql);
    $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}
