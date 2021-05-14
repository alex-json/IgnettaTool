<?php

/**
 * Description of WriterService
 *
 * @author Alejandro
 */

namespace App\Services;

use App\Services\DirectoryTranslatorService\WriterInterface;

class WriterService implements WriterInterface {

    public static function writeLangFile(string $filePath, array $lang, bool $version = true): void {
        
        $fh = fopen($filePath, "w");

        if (!is_resource($fh)) {
            throw new Exception('No se ha podido crear el archivo de destino');
        }

        fwrite($fh, "<?php\n");
        
        if($version){
            fwrite($fh, '$lang = [' . PHP_EOL);
        }else{
            fwrite($fh, 'return [' . PHP_EOL);
        }

        foreach ($lang as $key => $value) {
            $slashedString = addslashes($value);
            fwrite($fh, sprintf('\'%s\'=> \'%s\',' . PHP_EOL, $key, $slashedString));
        }

        fwrite($fh, PHP_EOL . '];');
        fclose($fh);
    }

}
