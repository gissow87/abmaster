<?php
require_once('./models/ViewModel.php');

/**
 * Se encarga de obtener las vistas a mostrar
 */
class ViewController extends ViewModel
{

    /**----- Controller to get template -----*/
    public function getTemplateController()
    {
        return require_once('./view/template.php');
    }

    /**----- Controller to get template -----*/
    public function getViewController()
    {
        $response = ViewModel::getViewModel("");
        if (isset($_GET["views"])) {
            $ruta =  explode("/", $_GET["views"]);
            $response = ViewModel::getViewModel($ruta[0]);
        }
        return $response;
    }
}
