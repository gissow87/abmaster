<?php

/**
 * Se encarga de obtener las vistas a mostrar
 */
class ViewModel
{
    protected static function getViewModel($xview)
    {
        //Página por defecto, para evitar urls falsas
        $content = "404-view.php";
        $whiteList = [
            "home",
            "client-list", "client-new", "client-search", "client-update",
            "company",
            "item-list", "item-new", "item-search", "item-update",
            "reservation-list", "reservation-new", "reservation-pending", "reservation-reservation",
            "reservation-search", "reservation-update",
            "user-list", "user-new", "user-search", "user-update"
        ];
        if (in_array($xview, $whiteList)) {
            if (is_file("./view/$xview-view.php")) {
                $content = "./view/$xview-view.php";
            }
        } else if ($xview == "login" || $xview == "index" || $xview == "") {
            $content = "login-view.php";
        }
        echo $content;
        return $content;
    }
}
