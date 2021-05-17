<?php
/**
 * Este es el servicio encargado de traducir, solo debe de tener un metodo
 * Este recibe el idioma de origen, el de destino y la frase a traducir
 * Devuelve la frase traducida
 */
namespace App\Services;
use App\Services\DirectoryTranslatorService\TranslatorInterface;

class FreeGoogleTranslationService implements TranslatorInterface{
    
    static $count = 0;
    
    static function translate(string $sl, string $lt, string $phrase, ?string $key): string 
    {
        if(FreeGoogleTranslationService::$count >= 15){
            $sleepAcum = mt_rand(30000,80000)/1000;
            sleep($sleepAcum);
            TranslationService::$count = 0;
        }
        
        $sleepTime = mt_rand(1000,2000)/1000;
        sleep($sleepTime);
        
        $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=$sl&tl=$lt&dt=t&q=" . urlencode($phrase);
        $resultado = @file_get_contents($url);
        
        if($resultado === false){
            $error = error_get_last();
            throw new \Exception($error["message"]);
        }
        
        FreeGoogleTranslationService::$count ++;
        
        $result    = json_decode($resultado);
        
        $returnString = '';
        foreach ($result[0] as $translation){
            $returnString .= $translation[0];
        }
        return($returnString);
    }

}
