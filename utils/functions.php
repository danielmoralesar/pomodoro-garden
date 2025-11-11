<?php
/**
 * printForHtml takes a string and return it formated for HTML
 * @param mixed $toPrint the string to print
 * @param mixed $tag the tag to use, by default, its a <p> tag
 * @param mixed $atributes atributes to use, by default, its blank
 * @param mixed $atributeValue atribute values to use, by default, its blank
 * @return string the formated string ready to be use in html
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
 * Finds an object in an array of objects, if not found, return false
 * else return the object
 * @param string $title
 * @param array $objects
 */
function findSomethingByTitle(string $title, array $objects){
    foreach ($objects as $object) {
        if ($object->getTitle() == $title){
            return $object;
        }
    }
    return false;
}

/**
 * Formatea un array en una lista no ordenada
 * @param array $arr
 * @return string
 */
function printArray(array $arr){
    $printableArr = "<ul>";
    foreach ($arr as $value) {
        $printableArr .= "<li>{$value->getTitle()}</li>";
    }
    return $printableArr . "</ul>";
}