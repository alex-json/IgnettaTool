<?php

namespace App\Services;

/**
 * Description of DirectoryCountService
 *
 * @author Alejandro
 */
class DirectoryCountService {

    public function __invoke(string $path, bool $version = true): int {
        $count = 0;

        //Si no existe la carpeta de origen lanza excepcion
        if (!file_exists($path)) {
            throw new Exception('El idioma de origen no existe');
        }

        foreach (new \DirectoryIterator($path) as $fileInfo) {
            
            //Por cada iteracion crea el nuevo archivo en la carpeta de destino
            if ($fileInfo->isDot()) {
                continue;
            }
            
            //Cargamos el archivo
            if($version){
                include_once $fileInfo->getPathname();
            }else{
                $lang = $this->getArrayLang($fileInfo->getPathname());
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
        return include_once $filePath;
    }

}

