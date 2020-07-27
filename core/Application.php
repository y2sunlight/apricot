<?php
namespace Apricot;

/**
 * Application class
 */
class Application
{
    /** @var Application Application instance */
    private static $instance = null;

    /** @var array Application settings */
    private $app = [];

    /** @var string Project directory */
    private $projectDir;

    /** @var string config directory */
    private $configDir;

    /** @var string assets directory */
    private $assetsDir;

    /** @var string var directory */
    private $varDir;

    /** @var string public directory */
    private $publicDir;

    /** @var string Route base path */
    private $routeBase;

    /** @var string Controller name */
    private $controllerName;

    /** @var string Action name */
    private $actionName;

    /**
     * Gets the project directory.
     *
     * @return string
     */
    public function getProjectDir():string
    {
        return $this->projectDir;
    }

    /**
     * Gets the config directory.
     *
     * @return string
     */
    public function getConfigDir():string
    {
        return $this->configDir;
    }

    /**
     * Gets the assets directory.
     *
     * @return string
     */
    public function getAssetsDir():string
    {
        return $this->assetsDir;
    }

    /**
     * Gets the var directory.
     *
     * @return string
     */
    public function getVarDir():string
    {
        return $this->varDir;
    }

    /**
     * Gets the public directory.
     *
     * @return string
     */
    public function getPublicDirectory():string
    {
        return $this->publicDir;
    }

    /**
     * Gets the route base path.
     *
     * @return string
     */
    public function getRouteBase():string
    {
        return $this->routeBase;
    }

    /**
     * Gets the controller name.
     *
     * @return string
     */
    public function getControllerName():string
    {
        return $this->controllerName;
    }

    /**
     * Gets the action name.
     *
     * @return string
     */
    public function getActionName():string
    {
        return $this->actionName;
    }

    /**
     * Gets the application instance.
     *
     * @return \Apricot\Application
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
     * Creates the application.
     *
     * @param string $projectDir
     * @param string $publicDir
     */
    function __construct(string $projectDir, string $publicDir)
    {
        if (!self::$instance)
        {
            // Sets project directories
            $this->projectDir = $projectDir;
            $this->configDir = $projectDir.'/config';
            $this->assetsDir = $projectDir.'/assets';
            $this->varDir = $projectDir.'/var';

            // Sets public directory
            $this->publicDir = $publicDir;

            // Sets route base path
            $routeBase = dirname($_SERVER['SCRIPT_NAME']);
            if (preg_match('/^[\\.\\\\]$/', $routeBase)) $routeBase='';
            $this->routeBase = $routeBase;

            // Sets Dotenv
            \Dotenv\Dotenv::createImmutable($projectDir)->load();

            // Sets timezone
            date_default_timezone_set(env('APP_TIMEZONE','UCT'));

            self::$instance = $this;
        }
    }

    /**
     * Gets the application setting specified by the Dot-notatio key.
     *
     * @param string|null $dot Dot-notation key
     * @param mixed $default
     * @return mixed
     */
    public function getSetting($dot = null, $default=null)
    {
        return array_get($this->app, $dot, $default);
    }

    /**
     * Checks if the given key in the application settings values is present.
     *
     * @param string $dot Dot-notation key
     * @return bool
     */
    public function hasSetting(string $dot):bool
    {
        return array_has($this->app, $dot);
    }

    /**
     * Sets up the application.
     *
     * @param array $app Application settings
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
     * Runs the application.
     *
     * @param callable $routeDefinitionCallback
     */
    public function run(callable $routeDefinitionCallback)
    {
        // Creates dispatcher
        $dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);

        // Fetchs method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strips query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?'))
        {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode(preg_replace('/index.php$/','',$uri));

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

                    // Ecexutes an action
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
     * Executes action.
     *
     * @param string $controllerName
     * @param string $actionName
     * @param array $params
     */
    private function executeAction(string $controllerName, string $actionName, array $params=[])
    {
        // Creates ActionInvoker
        $action = new Foundation\ActionInvoker($controllerName, $actionName, $params);

        // Creates Middleware pipeline
        $pipeline = new Foundation\Middleware\MiddlewarePipeline($this->app['middleware']);

        // Ecexutes an action
        $response = $pipeline->executeAction($action);
        if ($response instanceof Foundation\Response)
        {
            $response->commit();
        }
        else
        {
            abort(500,'No Response');
        }
    }
}
