<?php

require_once './vendor/autoload.php';

$app = new Ahc\Cli\Application('IgnettaTool', '0.0.1');

$app->add(new CLI\CountCommand(), 'c');

$app->add(new CLI\TranslateCommand(), 't');

$app->handle($_SERVER['argv']);