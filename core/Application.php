<?php
namespace Core;

/**
 * Application Class
 */
class Application
{
    /**
     * Application Instance
     * var Application
     */
    private static $instance = null;

    /**
     * Application Setting
     * @var array
     */
    private $app = [];

    /*
     * Project Directories
     */
    private $projectDir;
    private $configDir;
    private $assetsDir;
    private $varDir;

    /*
     * Public Directory
     */
    private $publicDir;

    /*
     * Route Base Path
     */
    private $routeBase;

    /*
     * Controller Name
     */
    private $controllerName;

    /*
     *Action Name;
     */
    private $actionName;

    /**
     * Get Project dir
     * @return string
     */
    public function getProjectDir():string {return $this->projectDir;}

    /**
     * Get config dir
     * @return string
     */
    public function getConfigDir():string {return $this->configDir; }

    /**
     * Get assets dir
     * @return string
     */
    public function getAssetsDir():string {return $this->assetsDir; }

    /**
     * Get var dir
     * @return string
     */
    public function getVarDir():string {return $this->varDir; }

    /**
     * Get Public Directory
     * @return string
     */
    public function getPublicDirectory():string {return $this->publicDir; }

    /**
     * Get Route Base Path
     * @return string
     */
    public function getRouteBase():string {return $this->routeBase; }

    /**
     * Get controller Name
     * @return string
     */
    public function getControllerName():string {return $this->controllerName; }

    /**
     * Get Action Name
     * @return string
     */
    public function getActionName():string {return $this->actionName; }

    /**
     * Get Application instance.
     * @return \Core\Application
     */
    static public function getInstance():Application
    {
        if (!self::$instance)
        {
            throw new \RuntimeException('Application has not been set.');
        }
        return self::$instance;
    }

    /**
     * Create Application
     * @param string $projectDir
     * @param string $publicDir
     */
    function __construct(string $projectDir, string $publicDir)
    {
        if (!self::$instance)
        {
            // Set Project Directories
            $this->projectDir = $projectDir;
            $this->configDir = $projectDir.'/config';
            $this->assetsDir = $projectDir.'/assets';
            $this->varDir = $projectDir.'/var';

            // Set Public Directory
            $this->publicDir = $publicDir;

            // Set Route Base Path
            $routeBase = dirname($_SERVER['SCRIPT_NAME']);
            if (preg_match('/^[\\.\\\\]$/', $routeBase)) $routeBase='';
            $this->routeBase = $routeBase;

            // Set Dotenv
            \Dotenv\Dotenv::createImmutable($projectDir)->load();

            // Set timezone
            date_default_timezone_set(env('APP_TIMEZONE','UCT'));

            self::$instance = $this;
        }
    }

    /**
     * Get an application setting value
     * @param string|null $dot Dot-notation key
     * @param mixed $default
     * @return mixed
     */
    public function getSetting($dot = null, $default=null)
    {
        return array_get($this->app, $dot, $default);
    }

    /**
     * Checks if an application setting key is present
     * @param string $dot Dot-notation key
     * @return bool
     */
    public function hasSetting(string $dot):bool
    {
        return array_has($this->app, $dot);
    }

    /**
     * Setup Application
     * @param array $app Application Setting
     */
    public function setup(array $app=[])
    {
        $this->app = $app;

        // Application setup
        if (!empty($this->app) && array_key_exists('setup', $this->app))
        {
            foreach($this->app['setup'] as $setup)
            {
                $func = require_once $setup;
                if (!is_callable($func) || ($func()===false))
                {
                    throw new \RuntimeException("Application Setup Error: {$setup}");
                }
            }
        }
    }

    /**
     * Run Application
     * @param callable $routeDefinitionCallback
     */
    public function run(callable $routeDefinitionCallback)
    {
        // Create Dispatcher
        $dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);

        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?'))
        {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0])
        {
            case \FastRoute\Dispatcher::NOT_FOUND:
                abort(404, 'Page Not Found');
                break;

            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                abort(405, 'Method Not Allowed');
                break;

            case \FastRoute\Dispatcher::FOUND:

                $handler = $routeInfo[1];
                $params = $routeInfo[2];

                if (is_callable($handler))
                {
                    // Case of callable
                    $handler($params);
                }
                elseif(strpos($handler,'@')!==false)
                {
                    // Case of Controller/Action
                    list($this->controllerName, $this->actionName) = explode('@', $handler);

                    // Ecexute action
                    $this->executeAction($this->controllerName, $this->actionName, $params);
                }
                else
                {
                    abort(500,'Action Not Found');
                }
                break;
        }
    }

    /**
     * Ecexute action
     * @param string $controllerName
     * @param string $actionName
     * @param array $params
     */
    private function executeAction(string $controllerName, string $actionName, array $params=[])
    {
        // Create ActionInvoker
        $action = new \Core\Foundation\ActionInvoker($controllerName, $actionName, $params);

        // Create Middleware pipeline
        $pipeline = new \Core\Foundation\Middleware\MiddlewarePipeline($this->app['middleware']);

        // Ecexute action
        $response = $pipeline->executeAction($action);
        if ($response instanceof \Core\Foundation\Response)
        {
            $response->commit();
        }
        else
        {
            abort(500,'No Response');
        }
    }
}
