<?php

require_once './vendor/autoload.php';

use App\Services\DirectoryTranslatorService\DirectoryTranslatorService;
use App\Services\WriterService;
use App\Services\DirectoryTranslatorService\DirectoryTranslatorOptions;

//Nombre de las carpetas de origen y destino
$idiomaOrigen  = 'es';
$idiomaDestino = 'it';

//Ruta absoluta de de la carpeta donde se va a trabajar
//$langPath = 'C:\xampp\htdocs\auto-translation\languages';
$langPath = 'C:\lang';

//Idioma de origen y destino en ISO
$orgAbrv  = 'es';
$destAbrv = 'it';

//Key API
$publicKey = '';

//Generamos los path de los archivos
$destPath = $langPath . DIRECTORY_SEPARATOR . $idiomaDestino;
$orgPath  = $langPath . DIRECTORY_SEPARATOR . $idiomaOrigen;

//Test

use Test\Services\FakeTranslationService;
$fakeTranslator = new FakeTranslationService();
$writer = new WriterService();
$translator = new DirectoryTranslatorService($fakeTranslator, $writer);
$translator(new DirectoryTranslatorOptions($orgPath, $destPath, $orgAbrv, $destAbrv, '',false));


//Traductor API Google
/*
use App\Services\FreeGoogleTranslationService;

$googleTranslator = new FreeGoogleTranslationService();
$writer = new WriterService();
$translator = new DirectoryTranslatorService($googleTranslator, $writer);
$translator(new DirectoryTranslatorOptions($orgPath, $destPath, $orgAbrv, $destAbrv, $publicKey, false));
*/
//Contador de letras
/*
use App\Services\DirectoryCountService;

$countServ = new DirectoryCountService();

echo PHP_EOL.$countServ($orgPath, false);
*/

/**
 * Funciones mockeadas que pueden aparecer en los $lang
 */
function site_url($url) {
    $debug   = debug_backtrace()[0];
    $fileArr = explode('\\', $debug['file']);
    $file    = $fileArr[count($fileArr) - 1];
    echo('Ha ocurrido un warning en el archivo: ' . $file . ' linea: ' . $debug['line']);
    return ".site_url('$url').";
}
