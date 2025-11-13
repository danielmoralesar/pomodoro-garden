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
 * Muestra por pantalla el valor de un boolean
 * @param bool $bool
 * @return string
 */
function printBool(bool $bool){
    return printForHtml($bool ? "True" : "False");
}