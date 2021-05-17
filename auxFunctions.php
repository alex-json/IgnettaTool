<?php
/**
 * Put here your custom function that can appear in your tranlation files
 */

function site_url($url) {
    $debug   = debug_backtrace()[0];
    $fileArr = explode('\\', $debug['file']);
    $file    = $fileArr[count($fileArr) - 1];
    echo('Ha ocurrido un warning en el archivo: ' . $file . ' linea: ' . $debug['line'] . PHP_EOL);
    return ".site_url('$url').";
}

