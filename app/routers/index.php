<?php

if (isset($_GET['authors'])):
    include '../app/routers/authors.php';

else:
    \App\Controllers\PagesController::homeAction();
endif;
