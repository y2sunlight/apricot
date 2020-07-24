<?php
/**
 * Returns the value of the environment variable specified by the key.
 *
 * @param string $key
 * @param mixed $default
 * @return mixed environment Variable
 */
function env($key, $default = null)
{
    // getenv() cannot be used with phpdotenv 5.0
    if (array_key_exists($key, $_ENV))
    {
        $value = $_ENV[$key];
    }
    else
    {
        return $default;
    }

    switch (strtolower($value))
    {
        case 'true': return true;
        case 'false':return false;
        case 'empty':return '';
        case 'null' :return null;
    }
    return $value;
}

/**
 * Throws an HTTP exception.
 *
 * @param int $code
 * @param string $message
 * @throws \Apricot\Exceptions\HttpException
 */
function abort(int $code, string $message=null)
{
    throw new Apricot\Exceptions\HttpException($code, $message);
}

/**
 * Returns the value of the application setting specified by the dot-notation key.
 *
 * @param string|null $dot dot-notation key
 * @param mixed $default
 * @return mixed
 */
function app($dot = null, $default=null)
{
    return Apricot\Application::getInstance()->getSetting($dot, $default);
}

/**
 * Checks if an application setting key is present.
 *
 * @param string $dot dot-notation key
 * @return bool
 */
function app_has($dot = null)
{
    return Apricot\Application::getInstance()->hasSetting($dot);
}

/**
 * Returns the full pathname in the project directory or its child directory.
 *
 * @param string $path Sub path, if necessary
 * @return string project directory or its children.
 */
function project_dir($path = null):string
{
    return add_path(Apricot\Application::getInstance()->getProjectDir(), $path);
}

/**
 * Returns the full pathname in the config directory or its child directory.
 *
 * @param string $path Sub path, if necessary
 * @return string config directory
 */
function config_dir($path = null):string
{
    return add_path(Apricot\Application::getInstance()->getConfigDir(), $path);
}

/**
 * Returns the full pathname in the assets directory or its child directory.
 *
 * @param string $path Sub path, if necessary
 * @return string assets directory
 */
function assets_dir($path = null):string
{
    return add_path(Apricot\Application::getInstance()->getAssetsDir(), $path);
}

/**
 * Returns the full pathname in the var directory or its child directory.
 *
 * @param string $path Sub path, if necessary
 * @return string var directory
 */
function var_dir($path = null):string
{
    return add_path(Apricot\Application::getInstance()->getVarDir(), $path);
}

/**
 * Returns the full pathname in the public directory or its child directory.
 *
 * @param string $path Sub path, if necessary
 * @return string public directory
 */
function public_dir($path = null):string
{
    return add_path(Apricot\Application::getInstance()->getPublicDirectory(),$path);
}

/**
 * Returns the application URL.
 *
 * @param string $path Sub path, if necessary
 * @return string URL
 */
function url($path = null):string
{
    // TODO: If there is no APP_URL, I have to create an absolute URL from Domain and Protocol.
    $base = env('APP_URL', Apricot\Application::getInstance()->getRouteBase());
    return add_path($base,$path);
}

/**
 * Returns a file URL with the application version.
 *
 * @param string $filename
 * @return string URL
 */
function url_ver(string $filename)
{
    return url($filename).'?v='.env('APP_VERSION');
}

/**
 * Returns the routing path.
 *
 * @param string $path Sub path, if necessary
 * @return string routing path
 */
function route($path = null):string
{
    return add_path(Apricot\Application::getInstance()->getRouteBase(),$path);
}

/**
 * Returns the current controller name.
 *
 * @return string name
 */
function controllerName():string
{
    return Apricot\Application::getInstance()->getControllerName();
}

/**
 * Returns the current action name.
 *
 * @return string name
 */
function actionName():string
{
    return Apricot\Application::getInstance()->getActionName();
}

/**
 * Returns the value of the configuration Variable specified by the dot-notation key.
 *
 * @param string $key dot-notation key
 * @param mixed $default
 * @return mixed configuration Variable
 */
function config($key, $default = null)
{
    return Apricot\Config::get($key, $default);
}

/**
 * Returns the translated message specified by the dot-notation key.
 *
 * @param string $key dot-notation key
 * @param string $params
 * @return string translated Message
 */
function __($key, $params = [])
{
    return Apricot\Lang::get($key, $params);
}

/**
 * Returns an array of input labels specified by the dot-notation key.
 *
 * @param string $message_key dot-notation key
 * @return array
 */
function inputLabels(string $message_key):array
{
    $labels = [];
    foreach(array_keys(Apricot\Input::all()) as $name)
    {
        $dot_key = "{$message_key}.{$name}";
        if (Apricot\Lang::has($dot_key))
        {
            $labels[$name] = Apricot\Lang::get($dot_key);
        }
    }
    return $labels;
}

/**
 * Returns the input data($_GET or $_POST depending on the post method) specified by the key.
 *
 * @param string $key
 * @param mixed $default
 * @return string
 */
function input(string $key, $default=null)
{
    return Apricot\Input::get($key, $default);
}

/**
 * Returns the QueryString($_GET) data specified by the key.
 *
 * @param string $key
 * @param mixed $default
 * @return string
 */
function queryString(string $key, $default=null)
{
    return Apricot\QueryString::get($key, $default);
}

/**
 * Returns the session data($_SESSION) specified by the key.
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function session(string $key, $default=null)
{
    return Apricot\Session::get($key, $default);
}

/**
 * Returns the flash data specified by the key.
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function flash(string $key, $default=null)
{
    return Apricot\Flash::get($key, $default);
}

/**
 * Returns the cookie data($_COOKIE) specified by the key.
 *
 * @param string $key
 * @param mixed $default
 * @return string
 */
function cookie(string $key, $default=null)
{
    return Apricot\Cookie::get($key, $default);
}

/**
 * Renders HTML via the given template and returns a response object.
 *
 * @param string $view Template name
 * @param array $variables An array of template variables
 * @return \Apricot\Foundation\Response\RenderResponse
 */
function render(string $view=null, array $variables=[]):Apricot\Foundation\Response\RenderResponse
{
    $variables['errors'] = errors();
    $html = isset($view) ? Apricot\View::run($view, $variables) : null;
    return new Apricot\Foundation\Response\RenderResponse($html);
}

/**
 * Returns a response object that redirects to the specified URL.
 *
 * @param string $url URL
 * @return \Apricot\Foundation\Response\RedirectResponse
 */
function redirect(string $url):Apricot\Foundation\Response\RedirectResponse
{
    return new Apricot\Foundation\Response\RedirectResponse($url);
}

/**
 * Returns the old input value flushed to the session, specified by the key.
 *
 * @param string $key
 * @param mixed $default
 * @return string
 */
function old(string $key, $default = null)
{
    $old_inputs = flash(Apricot\Foundation\Response::FLASH_KEY_OLD);
    return isset($old_inputs) && array_key_exists($key, $old_inputs) ? $old_inputs[$key] : $default;
}

/**
 * Returns an old URL path.
 *
 * @return string URL
 */
function back():string
{
    if (array_key_exists('HTTP_REFERER', $_SERVER) && isset($_SERVER['HTTP_REFERER']))
    {
        $url = '/';
        $info = parse_url($_SERVER['HTTP_REFERER']);
        if (array_key_exists('path',$info)) $url = $info['path'];
        if (array_key_exists('query',$info)) $url .= '?'.$info['query'];
        if (array_key_exists('fragment',$info)) $url .= '#'.$info['fragment'];
        return $url;
    }
    else
    {
        return flash(Apricot\Foundation\Response::FLASH_KEY_BACK, '/');
    }
}

/**
 * Returns response errors flashed into the session.
 *
 * @return \Apricot\Foundation\ErrorBag
 */
function errors():Apricot\Foundation\ErrorBag
{
    $errors = Apricot\Flash::has(Apricot\Foundation\Response::FLASH_KEY_ERRORS)
    ? flash(Apricot\Foundation\Response::FLASH_KEY_ERRORS)
    : new Apricot\Foundation\ErrorBag();

    return $errors;
}

