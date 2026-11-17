<?php

use \App\Controllers\AuthorsController;

switch ($_GET['authors']):
    default:
        AuthorsController::indexAction();
        break;
endswitch;
