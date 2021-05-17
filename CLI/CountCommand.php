<?php

namespace CLI;

/**
 * Description of CountCommand
 *
 * @author Alejandro
 */
class CountCommand extends \Ahc\Cli\Input\Command {

    public function __construct() {
        parent::__construct('count', 'Count the number of characters in all the files of the directory');

        $this
                ->argument('<dir>', 'The full path of the language you want to count')
                ->option('-c|--codver', 'The CodeIgniter version')
                // Usage examples:
                ->usage(
                        // append details or explanation of given example with ` ## ` so they will be uniformly aligned when shown
                        '<bold>  c</end> <comment>C:/your/path/to/languages/lang -c 4</end> ## The folder of the language and de CodeIgniter version<eol/>'
                );
    }

    // This method is auto called before `self::execute()` and receives `Interactor $io` instance
    public function interact(\Ahc\Cli\IO\Interactor $io) {
        // Collect missing opts/args

        if (!$this->codver) {

            $fruits = ['3' => 'CodeIgniter3', '4' => 'CodeIgniter4'];

            do {
                $choice = $io->choice('Selecciona version', $fruits);

                if ($choice != '3' && $choice != '4') {
                    $io->redBold('Accion selecciona no es valida', true);
                }
            } while ($choice != '3' && $choice != '4');

            $this->set('codver', $choice);
        }
    }

    // When app->handle() locates `init` command it automatically calls `execute()`
    // with correct $ball and $apple values
    public function execute($dir, $codver) {
        $io = $this->app()->io();
        try {

            switch ($codver) {
                case '3':
                    $version = true;
                    break;
                case '4':
                    $version = false;
                    break;
                default:
                    throw new \InvalidArgumentException('The version has to be 3 or 4');
            }

            $countServ = new \App\Services\DirectoryCountService();

            $res = $countServ($dir, $version);
            $io->greenBold('The number of characters is: ' . $res, true);
            
        } catch (\Exception $ex) {
            $io->redBold($ex->getMessage(), true);
        }
    }

}
