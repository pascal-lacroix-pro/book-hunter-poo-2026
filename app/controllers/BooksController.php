<?php

namespace App\Controllers;

use \App\Models\BooksManager;

abstract class BooksController
{

    public static function indexAction(): void
    {

        $books = BooksManager::findAll();

        global $title, $content;
        $title = "Latest Books";
        ob_start();
        include '../app/views/books/index.php';
        $content = ob_get_clean();
    }

    public static function showAction(int $id): void
    {
        $book = BooksManager::findOneById($id);

        global $title, $content;
        $title = $book->title;
        ob_start();
        include '../app/views/books/show.php';
        $content = ob_get_clean();
    }
}
