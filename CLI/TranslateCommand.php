<?php

namespace CLI;

/**
 * Description of CountCommand
 *
 * @author Alejandro
 */
class TranslateCommand extends \Ahc\Cli\Input\Command {

    public function __construct() {
        parent::__construct('translate', 'Translate all the files of a directory');

        $this
                ->argument('<dir>', 'The full path of the languages dir')
                ->argument('[sl]', 'The iso code for the origen language')
                ->argument('[tl]', 'The iso code for the target language')
                ->option('-t|--tf', 'The folder for the destination translations')
                ->option('-o|--sf', 'The folder for the origin translations')
                ->option('-s|--serv', 'The service name for translation[test, free, google] (google by default)')
                ->option('-c|--codver', 'The CodeIgniter version')
                ->option('-k|--key', 'The API key for google translation (Only needed if google service is selected)')

                // Usage examples:
                ->usage(
                        // Simply usage
                        '<bold>  t</end> <comment> C:/your/path/to/languages</end> ## The most simply usage<eol/>' .
                        // CodeIgniter3 example with all the param
                        '<bold>  t</end> <comment> C:/your/path/to/languages es en -c 3 -t english -o spanish -s google -k yourapikey</end> ## Codeigniter 3 example<eol/>' .
                        // CodeIgniter3 example with all the param
                        '<bold>  t</end> <comment> C:/your/path/to/languages es en -c 4 -s google -k yourapikey</end> ## Codeigniter 4 example<eol/>'
        );
    }

    // This method is auto called before `self::execute()` and receives `Interactor $io` instance
    public function interact(\Ahc\Cli\IO\Interactor $io) {
        // Collect missing opts/args
        if (!$this->codver) {

            $fruits = ['3' => 'CodeIgniter3', '4' => 'CodeIgniter4'];

            do {
                $choice = $io->choice('Select version', $fruits);

                if ($choice != '3' && $choice != '4') {
                    $io->redBold('The selection version is not correct', true);
                }
            } while ($choice != '3' && $choice != '4');

            $this->set('codver', $choice);
        }

        if (!$this->sl) {
            $this->set('sl', $io->prompt('Insert the ISO code of the origin lenguage'));
        }

        if (!$this->tl) {
            $this->set('tl', $io->prompt('Insert the ISO code of the target lenguage'));
        }

        if (!$this->sf && $this->codver == '3') {
            $this->set('sf', $io->prompt('Insert the folder name of the origin language'));
        }

        if (!$this->tf && $this->codver == '3') {
            $this->set('tf', $io->prompt('Insert the folder name of the destination language'));
        }

        if (!$this->tf && !$this->sf) {
            $io->warn("Not language folder provided, assuming the iso code as folder name", true);
            $this->set('tf', $this->tl);
            $this->set('sf', $this->sl);
        }

        if (!$this->serv) {

            $services = [
                'test'   => 'Service for test pruposes only',
                'free'   => 'Google free translate service, whit limit',
                'google' => 'Google translation API you neede a KEY'
            ];

            do {
                $choice = $io->choice('Select the service', $services);

                if ($choice != 'test' && $choice != 'free' && $choice != 'google') {
                    $io->redBold('Select a correct service', true);
                }
            } while ($choice != 'test' && $choice != 'free' && $choice != 'google');

            $this->set('serv', $choice);
        }

        if ($this->serv == 'google' && !$this->key) {
            $this->set('key', $io->prompt('Insert the Google translation API key'));
        }
    }

    // When app->handle() locates `init` command it automatically calls `execute()`
    // with correct $ball and $apple values
    public function execute($codver, $dir, $sf, $tf, $sl, $tl, $serv, $key = null) {
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

            if ($serv != 'test' && $serv != 'free' && $serv != 'google') {
                $io->redBold('The service name is not correct you must use: test, free or google', true);
            }

            //Generamos los path de los archivos
            $destPath = $dir . DIRECTORY_SEPARATOR . $tf;
            $orgPath  = $dir . DIRECTORY_SEPARATOR . $sf;

            //DTO para el caso de uso
            $useCaseOption = new \App\UseCase\TranslateUseCaseDTO($version, $serv,
                    $destPath, $orgPath, $sl,
                    $tl, $key);

            //Caso de uso a ejecutar
            $useCase = new \App\UseCase\TranslateDirectoryUseCase();
            $useCase($useCaseOption, $io);
        } catch (\Google\Cloud\Core\Exception\BadRequestException $ex) {
            $message = json_decode($ex->getMessage())->error->message;
            $io->error($message, true);
        } catch (\Exception $ex) {
            $io->error($ex->getMessage(), true);
        }
    }

}
