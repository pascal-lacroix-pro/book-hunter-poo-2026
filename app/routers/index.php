<?php
if (isset($_GET['books'])):
    include '../app/routers/books.php';

elseif (isset($_GET['authors'])):
    include '../app/routers/authors.php';

else:
    \App\Controllers\PagesController::homeAction();
endif;
