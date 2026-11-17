<?php

namespace App\Controllers;

use \App\Models\AuthorsManager;

abstract class AuthorsController
{

    public static function indexAction(): void
    {

        $authors = AuthorsManager::findAll();

        global $title, $content;
        $title = "Latest Authors";
        ob_start();
        include '../app/views/authors/index.php';
        $content = ob_get_clean();
    }
}
