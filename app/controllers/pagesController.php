<?php

namespace App\Controllers\PagesController;

use \PDO;
use \App\Models\BooksModel;

function homeAction(PDO $connexion): void
{
    include_once '../app/models/booksModel.php';
    $books = BooksModel\findAll($connexion, 3);

    global $title, $content;
    $title = "Latest Books & Authors";
    ob_start();
    include '../app/views/pages/home.php';
    $content = ob_get_clean();
}
