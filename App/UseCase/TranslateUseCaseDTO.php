<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\UseCase;

/**
 * Description of TranslateUseCaseDTO
 *
 * @author Alejandro
 */
class TranslateUseCaseDTO {

    private string $service;
    private string $orgPath;
    private string $destPath;
    private string $orgAbrv;
    private string $destAbrv;
    private string $key;

    /**
     * Define al version de CodeIgniter true 3 false 4
     * @var bool
     */
    private bool $version;

    function __construct(string $service, string $orgPath, string $destPath, string $orgAbrv, string $destAbrv, string $key, bool $version) {
        $this->service  = $service;
        $this->orgPath  = $orgPath;
        $this->destPath = $destPath;
        $this->orgAbrv  = $orgAbrv;
        $this->destAbrv = $destAbrv;
        $this->key      = $key;
        $this->version  = $version;
    }

    function getService(): string {
        return $this->service;
    }

    function getOrgPath(): string {
        return $this->orgPath;
    }

    function getDestPath(): string {
        return $this->destPath;
    }

    function getOrgAbrv(): string {
        return $this->orgAbrv;
    }

    function getDestAbrv(): string {
        return $this->destAbrv;
    }

    function getKey(): string {
        return $this->key;
    }

    function getVersion(): bool {
        return $this->version;
    }

}
