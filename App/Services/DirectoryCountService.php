<?php

namespace App\Services;

/**
 * Description of DirectoryCountService
 *
 * @author Alejandro
 */
class DirectoryCountService {

    public function __invoke(string $path, bool $version): int {
        $count = 0;

        //Si no existe la carpeta de origen lanza excepcion
        if (!file_exists($path)) {
            throw new \Exception('The source language folder not exists');
        }

        foreach (new \DirectoryIterator($path) as $fileInfo) {
            
            if ($fileInfo->getExtension() !== "php") {
                continue;
            }
            
            include_once './auxFunctions.php';
            
            //Cargamos el archivo
            if($version){
                include_once $fileInfo->getPathname();
            }else{
                $lang = $this->getArrayLang($fileInfo->getPathname());
            }
            
            if(!isset($lang)){
                throw new \InvalidArgumentException('The CodeIgniter version of the file don\'t match with the selected version');
            }
            
            foreach ($lang as $key => $value) {
                $count += strlen($value);
            }
            
        }

        return $count;
    }
    
    /*
     * Funcion para cargar el lang de codigniter4
     */
    private function getArrayLang(string $filePath){
         //return include_once 'C:\xampp\htdocs\auto-translation\lang\es\asignaciones_lang.php';
        return include_once $filePath;
    }

}

