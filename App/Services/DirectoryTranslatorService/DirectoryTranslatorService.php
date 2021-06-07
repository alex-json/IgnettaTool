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
    private \Ahc\Cli\IO\Interactor $io;

    public function __construct(TranslatorInterface $translator, WriterInterface $writer, \Ahc\Cli\IO\Interactor $io) {
        $this->translator = $translator;
        $this->writer     = $writer;
        $this->io         = $io;
    }

    public function __invoke(DirectoryTranslatorOptions $options) {

        //Si no existe la carpeta de origen lanza excepcion
        if (!file_exists($options->orgPath)) {
            throw new \Exception('The source language folder not exists');
        }

        //Crear una nueva carpeta para el lenguage de destino si no existe
        if (!file_exists($options->destPath)) {
            mkdir($options->destPath);
        }

        $traduccionesCont = 0;
        include_once './auxFunctions.php';
        foreach (new \DirectoryIterator($options->orgPath) as $fileInfo) {
            //Por cada iteracion crea el nuevo archivo en la carpeta de destino
            if ($fileInfo->getExtension() !== "php") {
                continue;
            }
            
            //Cargamos el archivo
            if ($options->version) {
                include_once $fileInfo->getPathname();
            } else {
                $lang = $this->getArrayLang($fileInfo->getPathname());
            }
            
            if(!isset($lang)){
                throw new \InvalidArgumentException('The CodeIgniter version of the file don\'t match with the selected version');
            }
            
            foreach ($lang as $key => $value) {
                $lang[$key] = $this->translator::translate($options->orgLang, $options->destLang, $value, $options->publicKey);
                $this->io->greenBold('Translated: ', false);
                $this->io->yellow($key, true);
                $traduccionesCont++;
            }

            $file = $options->destPath . DIRECTORY_SEPARATOR . $fileInfo->getFilename();
            $this->writer::writeLangFile($file, $lang, $options->version);
            $this->io->blackBgGreen("Finished file: " . $fileInfo->getFilename(), true);
            $this->io->blackBgYellow("Numers of traductions: $traduccionesCont", true);

            $lang = [];
        }
    }

    private function getArrayLang(string $filePath) {
        return include_once $filePath;
    }

}
