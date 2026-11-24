<?php

use \App\Controllers\BooksController;

switch ($_GET['books']):
    default:
        BooksController::indexAction();
        break;
endswitch;
