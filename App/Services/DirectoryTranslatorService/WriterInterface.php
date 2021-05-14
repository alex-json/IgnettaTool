<?php
namespace App\Services\DirectoryTranslatorService;

interface WriterInterface {
    public static function writeLangFile(string $filePath, array $lang): void;
}
