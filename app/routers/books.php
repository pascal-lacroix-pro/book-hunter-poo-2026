<?php

use \App\Controllers\BooksController;

switch ($_GET['books']):
    case 'show':
        BooksController::showAction($_GET['id']);
        break;
    default:
        BooksController::indexAction();
        break;
endswitch;
