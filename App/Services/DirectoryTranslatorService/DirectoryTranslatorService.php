<?php

namespace App\Services\DirectoryTranslatorService;

/**
 * Description of DirectoryTranslatorService
 *
 * @author Alejandro
 */
class DirectoryTranslatorService {

    private TranslatorInterface $translator;
    private WriterInterface $writer;

    public function __construct(TranslatorInterface $translator, WriterInterface $writer) {
        $this->translator = $translator;
        $this->writer     = $writer;
    }

    public function __invoke(DirectoryTranslatorOptions $options) {

        //Si no existe la carpeta de origen lanza excepcion
        if (!file_exists($options->orgPath)) {
            throw new Exception('El idioma de origen no existe');
        }

        //Crear una nueva carpeta para el lenguage de destino si no existe
        if (!file_exists($options->destPath)) {
            mkdir($options->destPath);
        }

        $traduccionesCont = 0;
        foreach (new \DirectoryIterator($options->orgPath) as $fileInfo) {
            //Por cada iteracion crea el nuevo archivo en la carpeta de destino
            if ($fileInfo->isDot()) {
                continue;
            }

            //Cargamos el archivo
            if($options->version){
                include_once $fileInfo->getPathname();
            }else{
                $lang = $this->getArrayLang($fileInfo->getPathname());
            }

            foreach ($lang as $key => $value) {
                $lang[$key] = $this->translator::translate($options->orgLang, $options->destLang, $value, $options->publicKey);
                echo "Traducido:$key<br/>";
                $traduccionesCont++;
            }

            $file = $options->destPath . DIRECTORY_SEPARATOR . $fileInfo->getFilename();
            $this->writer::writeLangFile($file, $lang, $options->version);
            echo "<h1 style='color: green'>Terminado archivo: " . $fileInfo->getFilename() . "</h1> "
            . "<h1 style='color: yellow'>Num traducciones: $traduccionesCont</h1><br/>";
            $lang = [];
        }
        
    }

    /**
     * Funciones mockeadas que pueden aparecer en los $lang
     */
    private function site_url($url) {
        $debug   = debug_backtrace()[0];
        $fileArr = explode('\\', $debug['file']);
        $file    = $fileArr[count($fileArr) - 1];
        echo('Ha ocurrido un warning en el archivo: ' . $file . ' linea: ' . $debug['line']);
        return ".site_url('$url').";
    }
    
    /*
     * Funcion para cargar el lang de codigniter4
     */
    private function getArrayLang(string $filePath){
        return include_once $filePath;
    }
    
    /*
     * Traduce el array
     */
    private function translateArray(array $lang){
        
    }

}
