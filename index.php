<?php
require_once ("./config/config.php");
require_once ("./controllers/ViewController.php");

$template = new ViewController();
$template->getTemplateController();