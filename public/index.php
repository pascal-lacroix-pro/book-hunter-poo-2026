<?php

require_once '../core/init.php';

echo \Core\Helpers::slugify("Oufti que c'est bien !");
die();
require_once '../app/routers/index.php';
require_once '../app/views/templates/default.php';
