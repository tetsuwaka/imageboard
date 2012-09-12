<?php

require_once '../controller/indexController.php';
$controller = new indexController();
$controller->control('../view/indexView.php');