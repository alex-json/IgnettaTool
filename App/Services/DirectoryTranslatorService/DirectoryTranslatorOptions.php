<?php

namespace App\Services\DirectoryTranslatorService;

class DirectoryTranslatorOptions {

    /**
     * Path absoluto de la carpeta de origen
     * @var string
     */
    private string $orgPath;

    /**
     * Path absoluto de la carpeta de destino
     * @var string
     */
    private string $destPath;

    /**
     * Lenguage de origen en formato ISO
     * @var string
     */
    private string $orgLang;

    /**
     * Lenguage de destino en formato ISO
     * @var string
     */
    private string $destLang;

    /**
     * Clave publica para la llamada a la API(opcional segun la API)
     * @var string
     */
    private ?string $publicKey;

    /**
     * Booleano que define la version de codeigniter, true para 3 false para 4
     * @var string
     */
    private bool $version;

    public function __construct(string $orgPath,
            string $destPath,
            string $orgLang,
            string $destLang,
            bool $version,
            ?string $publicKey
    ) {
        $this->orgPath   = $orgPath;
        $this->destPath  = $destPath;
        $this->orgLang   = $orgLang;
        $this->destLang  = $destLang;
        $this->publicKey = $publicKey;
        $this->version   = $version;
    }

    public function __get($name) {
        switch ($name) {
            case('orgPath'):
                return $this->orgPath;
            case('destPath'):
                return $this->destPath;
            case('orgLang'):
                return $this->orgLang;
            case('destLang'):
                return $this->destLang;
            case('publicKey'):
                return $this->publicKey;
            case('version'):
                return $this->version;
        }
    }

}
