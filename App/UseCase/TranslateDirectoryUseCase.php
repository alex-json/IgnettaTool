<?php
namespace App\UseCase;
use App\Services\WriterService;
use App\Services\DirectoryTranslatorService\DirectoryTranslatorService;
use App\Services\DirectoryTranslatorService\DirectoryTranslatorOptions;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TranslateDirectoryUseCase
 *
 * @author Alejandro
 */
class TranslateDirectoryUseCase {
    
    public function __invoke(TranslateUseCaseDTO $option) {
        
        switch($option->getService()){
            case 'test':
                $translator = new \Test\Services\FakeTranslationService();
                break;
            case 'free':
                $translator = new \App\Services\FreeGoogleTranslationService();
                break;
            case 'google':
                $translator = new \App\Services\GoogleTranslationService();
                break;
        }

        $writer = new WriterService();
        $translator = new DirectoryTranslatorService($translator, $writer);
        $translator(new DirectoryTranslatorOptions($option->getOrgPath(), 
                $option->getDestPath(), $option->getOrgAbrv(), 
                $option->getDestAbrv(), $option->getKey(), 
                $option->getKey())
                );
    }
}
