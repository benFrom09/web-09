<?php
namespace App\Support;

use Twig\TwigFunction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class View
{
    /**
     * Undocumented variable
     *
     * @var ResponseInterface $response
     */
   protected static $response;

    /**
     * View  directory
     *
     * @var string $dir
     */
    protected static $dir;

    /**
     * Path to cache
     *
     * @var string $cache
     */
    protected static $cache;

    /**
     * Twig File System Loader
     *
     * @var \Twig\Loader\FilesystemLoader
     */
    protected static $loader;
    /**
     *Twig Environment
     *
     * @var \Twig\Environment
     */
    protected static $environment;

    /**
     * File extension
     *
     * @var string
     */
    protected static $ext = '.php';

    protected static $functions;
    protected static $globals;

    /**
     * Set up View FileSytem and Response
     *
     * @param ResponseFactoryInterface $factory
     * @return void
     */

    public static function setUp(ResponseFactoryInterface $factory,array $functions = [],array $globals = []) {

        self::$response = $factory->createResponse(200,'Success');

        self::$dir = config('twig.view_dir');
        self:: $cache = config('twig.cache');
         //set twig filesystem
        $loader = new \Twig\Loader\FilesystemLoader(self::$dir);
        self::$environment = new \Twig\Environment($loader, [
                //'cache' => '/path/to/compilation_cache',
                self::$cache
        ]);
        //set extention   
        self::$ext = config('twig.ext');
        self::$functions = $functions;
        self::$globals = $globals;
        if(!empty(self::$functions)) {
            foreach(self::$functions as $function) {
                self::addFunctions($function);
            }
        }
        if(!empty(self::$globals)) {
            foreach(self::$globals as $key => $global) {
                self::$environment->addGlobal($key,$global);
            }
        }      
    }

    public static function addFunctions(TwigFunction $function) {
        return self::$environment->addFunction($function);
    }

    /**
     * Render the View
     *
     * @param string $template
     * @param array $with
     * @return ResponseInterface
     */
    public static function render(string $template,array $with = []):ResponseInterface
    {
        //replace @ or . by slash in string template
        $template = preg_replace('/@|\./','/',$template) . self::$ext;
        //check for file and render
        if(file_exists(self::$dir . DIRECTORY_SEPARATOR . $template)) {
            self::$response->getBody()->write(self::$environment->render($template,$with));
            return self::$response;
        } else {
            throw new \Exception('Unnable to find ' . $template);
        }
    }
}