<?php
if ($requestAjax) {
    require_once('../config/config.php');
} else {
    require_once('./config/config.php');
}


class MainModel
{

    /**------Función para conectarse a la DB------ */
    protected static function connectDB()
    {
        $bd = new PDO(SGDB, DB_USER, DB_PASS);
        //Es para evitar cualquier problema con datos, ejemplo las "Ñ"
        $bd->exec("SET CHARACTER SET utf8");
        return $bd;
    }

    /** ------Función para conectarse a la DB------
     * @param string $xsql consulta como tal, EJEMPLO: "SELECT * FROM tabla"
     * @return PDO retorna el objeto PDO con el resultado de la consulta
     */
    protected static function execQuery($xsql)
    {
        $sql = self::connectDB()->prepare($xsql);
        $sql->execute();
        return $sql;
    }

    /**
     * @param string $xstring valor a encriptar
     * @return string valor ya encriptado
     */
    public function encrypt($xstring)
    {
        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($xstring, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    /**
     * @param string $xstring valor a desencriptar
     * @return string valor ya desencriptado
     */
    protected function uncrypt($xstring)
    {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($xstring), METHOD, $key, 0, $iv);
        return $output;
    }

    /**
     * ------ Función para generar códigos aleatorios
     * @param string $xletra Letra inicial en el código aleatorio
     * @param int $xlongitud longitud final del código aleatorio
     * @param int $xid id del valor en la DB
     */
    protected function generateRandomCode($xletra, $xlongitud, $xid)
    {
        for ($i = 0; $i < $xlongitud; $i++) {
            $numAleatorio = rand(0, 9);
            $xletra .= $numAleatorio;
        }
        return $xletra . "-" . $xid;
    }

    /**
     * Función para limpiar consultas y evitar inyecciones SQL
     * @param string $xstrin cadena a limpiar
     * @return string cadena ya limpia
     */
    protected static function clearString($xstring)
    {
        //Elimina etiquetas scripts, y SQLs
        $cadena = str_replace("<script>", "", $xstring);
        $cadena = str_replace("<script src", "", $cadena);
        $cadena = str_replace("<script type=>", "", $cadena);
        $cadena = str_replace("SELECT * FROM", "", $cadena);
        $cadena = str_replace("DELETE * FROM", "", $cadena);
        $cadena = str_replace("DROP TABLE", "", $cadena);
        $cadena = str_replace("DROP DATABASE", "", $cadena);
        $cadena = str_replace("TRUNCATE TABLE", "", $cadena);
        $cadena = str_replace("SHOW TABLES", "", $cadena);
        $cadena = str_replace("SHOW DATABASES", "", $cadena);
        $cadena = str_replace("<?php", "", $cadena);
        $cadena = str_replace("<?", "", $cadena);
        $cadena = str_replace("--", "", $cadena);
        $cadena = str_replace(">", "", $cadena);
        $cadena = str_replace("<", "", $cadena);
        $cadena = str_replace("[", "", $cadena);
        $cadena = str_replace("]", "", $cadena);
        $cadena = str_replace("^", "", $cadena);
        $cadena = str_replace("==", "", $cadena);
        $cadena = str_replace(";", "", $cadena);
        $cadena = str_replace("..", "", $cadena);
        //Elimina barras invertidas "\"
        $cadena = stripslashes($cadena);
        //Elimina espacios al inicio y al final
        $cadena = trim($xstring);
        return $cadena;
    }

    /**
     * Función para validar datos según patrón dado
     * @param string $xpatern valores con los que verifica la cadena
     * @param string $xstring cadena a verificar
     * @return bool true si es válido, false si no lo es
     */
    protected static function verifyData($xpatern, $xstring)
    {
        if (preg_match("/^" . $xpatern . "$/", $xstring))
            return true;
        return false;
    }

    /**
     * Función para verificar si la fecha tiene un formato válido
     * @param string $xdate fecha a verificar
     * @return bool true si es válida, false de lo contrario
     */
    protected function verifyDate($xdate)
    {
        $values = explode("-", $xdate);
        if (count($values) == 3 && checkdate($values[1], $values[0], $values[2]))
            return true;
        return false;
    }

    protected static function tablePaginator($xpage, $xnPages, $xurl, $xcantButtons)
    {
        $table = '  <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">';

        //Icono anterior
        if ($xpage == 1) {
            $table .= ' <li class="page-item disabled">
                            <a class="page-link" href="" tabindex="-1">
                                <i class="fa-solid fa-angles-left"></i>
                            </a>
                        </li>';
        } else {
            $table .= ' <li class="page-item">
                            <a class="page-link" href="' . $xurl . '1/" tabindex="-1">
                                <i class="fa-solid fa-angles-left"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="' . $xurl . ($xpage - 1) . '/" tabindex="-1">
                                Anterior
                            </a>
                        </li>';
        }

        $contador = 0;
        for ($i = $xpage; $i <= $xnPages; $i++) {
            if ($contador >= $xcantButtons)
                break;

            if ($i == $xpage) {
                $table .= ' <li class="page-item">
                                <a class="page-link active" href="' . $xurl . $i . '/">' . $i . '</a>
                            </li>';
            } else {
                $table .= ' <li class="page-item">
                                <a class="page-link" href="' . $xurl . $i . '/">' . $i . '</a>
                            </li>';
            }
            $contador++;
        }



        //Botones anterior y inicio
        if ($xpage == $xnPages) {
            $table .= '     <li class="page-item disabled">
                                <a class="page-link" href="" tabindex="-1">
                                    <i class="fa-solid fa-angles-right"></i>
                                </a>
                            </li>';
        }
        //Botones siguiente y final
        else {
            $table .= '     <li class="page-item">
                                <a class="page-link" href="' . $xurl . ($xpage + 1) . '/" tabindex="-1">
                                    Siguiente
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="' . $xurl . $xnPages . '/" tabindex="-1">
                                    <i class="fa-solid fa-angles-right"></i>
                                </a>
                            </li>';
        }

        $table .= '     </ul>
                    </nav>';

        return $table;
    }
}
