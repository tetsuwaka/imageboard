<?php

require_once '../controller/commentController.php';
$controller = new commentController();
$controller->control('../view/commentView.php');
