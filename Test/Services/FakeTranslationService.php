<?php

namespace Test\Services;

use App\Services\DirectoryTranslatorService\TranslatorInterface;

class FakeTranslationService implements TranslatorInterface {

    public static function translate(string $sl, string $lt, string $phrase, ?string $key): string {
        sleep(1);
        return('FakeTranslation');
    }

}
