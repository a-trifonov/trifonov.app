<?php  

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once 'app/controllers/LoansController.php';

    $controller = new LoansController();

    $controller->handleRequest();

?>