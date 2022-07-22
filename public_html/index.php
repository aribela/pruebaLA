<?php
	session_unset();
	// require_once  '../php/controller/sportsController.php';		
    // $controller = new sportsController();	
    // $controller->mvcHandler();
    require_once  '../php/controller/dashboardController.php';		
    $controller = new dashboardController();	
    $controller->mvcHandler();
?>