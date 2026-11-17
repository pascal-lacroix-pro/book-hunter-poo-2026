<?php

namespace App\Controllers;

use \PDO;
use \App\Models\BooksManager;

abstract class PagesController
{

    public static function homeAction(PDO $connexion): void
    {

        $books = BooksManager::findAll($connexion, 3);

        global $title, $content;
        $title = "Latest Books & Authors";
        ob_start();
        include '../app/views/pages/home.php';
        $content = ob_get_clean();
    }
}
