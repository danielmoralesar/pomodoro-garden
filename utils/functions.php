<?php
/**
 * Obtiene un array y lo devuelve formateado para HTML
 * @param mixed $toPrint el String a formatear
 * @param mixed $tag la etiqueta a usar, por defecto es una de párrafo
 * @param mixed $atributes atributos a usar, si no se necesita ninguno, dejar vacio
 * @param mixed $atributeValue valores de atributos a usar, si no se necesita ninguno, dejar vacio
 * @return string
 */
function printForHtml($toPrint, $tag = "p", $atributes = "", $atributeValue = "")
{
    if (str_word_count($atributes) == 0) {
        return "<$tag>$toPrint</$tag>";
    } else {
        return "<$tag $atributes" . "=" . "'$atributeValue'" . ">$toPrint</$tag>";
    }
}

/**
 * Verifica si en un array de objetos, existe un objeto con el título dado,
 * Si existe el objeto, lo devuelve, sino, devuelve false
 * @param string $title
 * @param array $objects
 * @return bool
 */
function findSomethingByTitle(string $title, array $objects)
{
    foreach ($objects as $object) {
        if ($object->getTitle() == $title) {
            return $object;
        }
    }
    return false;
}

/**
 * Formatea un array con los títulos de un objeto en una lista no ordenada
 * @param array $arr
 * @return string
 */
function printObjectArray(array $arr)
{
    $printableArr = "<ul>";
    foreach ($arr as $value) {
        $printableArr .= printForHtml($value->getTitle(), "li");
    }
    return $printableArr . "</ul>";
}

/**
 * Formatea un array de valores simples en una lista no ordenada
 * Warning: no funciona con objetos, para eso se debe usar printObjectArray()
 * @param array $arr
 * @return string
 */
function printSimpleArray(array $arr){
    $printableArr = "<ul>";
    foreach ($arr as $value) {
        $printableArr .= printForHtml($value, "li");
    }
    return $printableArr . "</ul>";
}

/**
 * Formatea un array de fechas en formato Unix a formato día-mes-año
 * @param array $arr
 * @return string
 */
function printDatesArray(array $arr){
    $printableArr = "<ul>";
    foreach ($arr as $value) {
        $printableArr .= printForHtml(date("d-m-Y", $value), "li");
    }
    return $printableArr . "</ul>";
}

/**
 * Muestra por pantalla el valor de un boolean
 * @param bool $bool
 * @return string
 */
function printBool(bool $bool){
    return printForHtml($bool ? "True" : "False");
}

/**
 * Securiza los inputs recibidos por formularios
 * @param mixed $input
 * @return string
 */
function secure($input): string{
    return htmlspecialchars(stripslashes(trim($input)));
}

/**
 * Hashea las contraseñas dadas en texto plano
 * Es obligatorio hashear las contraseñas antes de crear el objeto usuario
 * @param mixed $pass
 * @return string
 */
function hashPass($pass): string{
    return password_hash($pass, PASSWORD_ARGON2ID);
}

/**
 * Verifica si el tipo de dato pasado por el usuario es correcto o no
 * @param string $data
 * @return string|null
 */
function checkUserDataType(string $data): ?string{
    return match (trim($data)){
        'email' => 'email',
        'name' => 'name',
        'id' => 'id',
        default => null
    };
}

/**
 * Verifica si el tipo dado por la planta es correcta o no
 * @param string $data
 * @return string|null
 */
function checkPlantDataType(string $data): ?string{
    return match (trim($data)){
        'title' => 'title',
        'id' => 'id',
        default => null
    };
}

/**
 * Da la propiedad active a la página donde se encuentre el usuario
 * @param string $location
 * @return string
 */
function activeHeader(string $location): string{
    return $_SERVER['PHP_SELF'] == "/public/$location.php" ? "active" : "";
}

/**
 * Convierte tiempo unix a días, meses y años
 * @param int $date
 * @return string
 */
function convertUnixToDate(int $date): string{
    return gmdate("d-m-Y", $date);
}

/**
 * Convierte tiempo unix a días.
 * @param int $time
 * @return string
 */
function convertSecondsToDays(int $time): int {
    return round($time / 86400);
}