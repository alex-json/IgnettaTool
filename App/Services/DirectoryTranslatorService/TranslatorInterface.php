<?php

namespace App\Services\DirectoryTranslatorService;

interface TranslatorInterface {
    public static function translate(string $sl, string $lt, string $phrase, string $key): string;
}
