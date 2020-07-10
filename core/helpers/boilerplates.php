<?php
/**
 * Get Environment Variable
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
 * Abort
 * @param int $code
 * @param string $message
 * @throws \Core\Exceptions\HttpException
 */
function abort(int $code, string $message=null)
{
    throw new Core\Exceptions\HttpException($code, $message);
}

/**
 * Get application setting value
 * @param string|null $dot Dot-notation key
 * @param mixed $default
 * @return mixed
 */
function app($dot = null, $default=null)
{
    return Core\Application::getInstance()->getSetting($dot, $default);
}

/**
 * Checks if an application setting key is present
 * @param string $dot Dot-notation key
 * @return bool
 */
function app_has($dot = null)
{
    return Core\Application::getInstance()->hasSetting($dot);
}

/**
 * Get project directory
 * @param string|null $default
 * @return string project directory
 */
function project_dir($path = null):string
{
    return add_path(Core\Application::getInstance()->getProjectDir(), $path);
}

/**
 * Get config directory
 * @param string $path Sub path, if necessary
 * @return string config directory
 */
function config_dir($path = null):string
{
    return add_path(Core\Application::getInstance()->getConfigDir(), $path);
}

/**
 * Get assets directory
 * @param string $path Sub path, if necessary
 * @return string assets directory
 */
function assets_dir($path = null):string
{
    return add_path(Core\Application::getInstance()->getAssetsDir(), $path);
}

/**
 * Get var directory
 * @param string $path Sub path, if necessary
 * @return string var directory
 */
function var_dir($path = null):string
{
    return add_path(Core\Application::getInstance()->getVarDir(), $path);
}

/**
 * Get public directory
 * @param string $path Sub path, if necessary
 * @return string public directory
 */
function public_dir($path = null):string
{
    return add_path(Core\Application::getInstance()->getPublicDirectory(),$path);
}

/**
 * Get application URL
 * @param string $path Sub path, if necessary
 * @return string URL
 */
function url($path = null):string
{
    // TODO: APP_URLが無い時は、DomainとProtocolから絶対URLを作る
    $base = env('APP_URL', Core\Application::getInstance()->getRouteBase());
    return add_path($base,$path);
}

/**
 * Get file URL With version
 * @param string $filename
 * @return string URL
 */
function url_ver(string $filename)
{
    return url($filename).'?v='.env('APP_VERSION');
}

/**
 * Get routing path
 * @param string $path Sub path, if necessary
 * @return string routing path
 */
function route($path = null):string
{
    return add_path(Core\Application::getInstance()->getRouteBase(),$path);
}

/**
 * Get current controller name
 * @return string name
 */
function controllerName():string
{
    return Core\Application::getInstance()->getControllerName();
}

/**
 * Get current action name
 * @return string name
 */
function actionName():string
{
    return Core\Application::getInstance()->getActionName();
}

/**
 * Get Configuration Variable
 * @param string $key
 * @param mixed $default
 * @return mixed configuration Variable
 */
function config($key, $default = null)
{
    return Core\Config::get($key, $default);
}

/**
 * Get Translated Message
 * @param string $key
 * @param string $params
 * @return string translated Message
 */
function __($key, $params = [])
{
    return Core\Lang::get($key, $params);
}

/**
 * Get Input Labels
 * @param string $message_key
 * @return array
 */
function inputLabels(string $message_key):array
{
    $labels = [];
    foreach(array_keys(Core\Input::all()) as $name)
    {
        $dot_key = "{$message_key}.{$name}";
        if (Core\Lang::has($dot_key))
        {
            $labels[$name] = Core\Lang::get($dot_key);
        }
    }
    return $labels;
}

/**
 * Get input($_GET or $_POST depending on the method) data
 * @param string $key
 * @param mixed $default
 * @return string
 */
function input(string $key, $default=null)
{
    return Core\Input::get($key, $default);
}

/**
 * Get QueryString data
 * @param string $key
 * @param mixed $default
 * @return string
 */
function queryString(string $key, $default=null)
{
    return Core\QueryString::get($key, $default);
}

/**
 * Get session($_SESSION) date
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function session(string $key, $default=null)
{
    return Core\Session::get($key, $default);
}

/**
 * Get flash date
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function flash(string $key, $default=null)
{
    return Core\Flash::get($key, $default);
}

/**
 * Get cookie($_COOKIE) date
 * @param string $key
 * @param mixed $default
 * @return string
 */
function cookie(string $key, $default=null)
{
    return Core\Cookie::get($key, $default);
}

/**
 * render
 * @param string $view テンプレート名
 * @param array $variables テンプレート変数のハッシュ
 * @return \Core\Foundation\Response\RenderResponse
 */
function render(string $view=null, array $variables=[]):Core\Foundation\Response\RenderResponse
{
    $variables['errors'] = errors();
    $html = isset($view) ? Core\View::run($view, $variables) : null;
    return new Core\Foundation\Response\RenderResponse($html);
}

/**
 * redirect
 * @param string $url URL
 * @return \Core\Foundation\Response\RedirectResponse
 */
function redirect(string $url):Core\Foundation\Response\RedirectResponse
{
    return new Core\Foundation\Response\RedirectResponse($url);
}

/**
 * Get old request inputs
 * @param string $key
 * @param mixed $default
 * @return string
 */
function old(string $key, $default = null)
{
    $old_inputs = flash(Core\Foundation\Response::FLASH_KEY_OLD);
    return isset($old_inputs) && array_key_exists($key, $old_inputs) ? $old_inputs[$key] : $default;
}

/**
 * Get old URL Path
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
        return flash(Core\Foundation\Response::FLASH_KEY_BACK, '/');
    }
}

/**
 * Get response errors
 * @return \Core\Foundation\ErrorBag
 */
function errors():Core\Foundation\ErrorBag
{
    $errors = Core\Flash::has(Core\Foundation\Response::FLASH_KEY_ERRORS)
    ? flash(Core\Foundation\Response::FLASH_KEY_ERRORS)
    : new Core\Foundation\ErrorBag();

    return $errors;
}

