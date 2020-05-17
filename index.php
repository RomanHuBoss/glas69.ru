<?php

session_start();

include 'Utils/autoload.php';

use Glas\Controllers\CFrontController;
use Glas\Models\CUserModel;

try {
    (new CFrontController(CUserModel::getFromSession()))->handleRequest();
}
catch (Exception $e) {
    exit($e->getMessage());
}


