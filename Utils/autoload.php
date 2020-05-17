<?php


/**
 * регистрация callback автозагрузки классов
 */
spl_autoload_register(function ($className) {
    $className = preg_replace("/^([\\\]*Glas|[\\\]*)/is", "", $className);
    include $_SERVER['DOCUMENT_ROOT']. $className . '.php';
});