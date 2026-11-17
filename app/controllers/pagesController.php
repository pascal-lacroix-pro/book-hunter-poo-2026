<?php

namespace App\Controllers;

use \App\Models\BooksManager;

abstract class PagesController
{

    public static function homeAction(): void
    {

        $books = BooksManager::findAll(3);

        global $title, $content;
        $title = "Latest Books & Authors";
        ob_start();
        include '../app/views/pages/home.php';
        $content = ob_get_clean();
    }
}
