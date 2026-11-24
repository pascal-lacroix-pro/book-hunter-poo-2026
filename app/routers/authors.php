<?php

use \App\Controllers\AuthorsController;

switch ($_GET['authors']):
    case 'show':
        AuthorsController::showAction($_GET['id']);
        break;
    default:
        AuthorsController::indexAction();
        break;
endswitch;
