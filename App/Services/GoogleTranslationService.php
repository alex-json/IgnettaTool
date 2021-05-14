<?php

namespace App\Services;

use Google\Cloud\Translate\V2\TranslateClient;
use App\Services\DirectoryTranslatorService\TranslatorInterface;

class GoogleTranslationService implements TranslatorInterface {

    public static function translate(string $sl, string $lt, string $phrase, string $key): string {
        $translate = new TranslateClient([
            'key' => $key
        ]);

        $result = $translate->translate($phrase, [
            'target' => $lt,
            'source' => $sl
        ]);

        return $result['text'];
    }

}
