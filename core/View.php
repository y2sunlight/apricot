<?php
namespace Core;

use Core\Foundation\Singleton;
use eftec\bladeone\BladeOne;

/**
 * View Class - BladeOne Wrapper
 *
 * @method static BladeOne getInstance();
 * @method static string run(string $view, array $variables = []) run the blade engine. It returns the result of the code.
 * @method static void setAuth($user = '', $role = null, $permission = []) Authentication. Sets with a user,role and permission
 * @method static void share($varname, $value) Adds a global variable
 * @method static BladeOne setOptimize($bool = false) If true then it optimizes the result (it removes tab and extra spaces).
 * @method static BladeOne setIsCompiled($bool = false) If false then the file is not compiled and it is executed directly from the memory. By default the value is true. It also sets the mode to MODE_SLOW.
 * @method static void setMode(int $mode) Set the compile mode
 * @method static void setFileExtension(string $fileExtension) Set the file extension for the template files. It must includes the leading dot e.g. .blade.php
 * @method static string getFileExtension() Get the file extension for template files.
 * @method static void setCompiledExtension(string $fileExtension) Set the file extension for the compiled files. Including the leading dot for the extension is required, e.g. .bladec
 * @method static string getCompiledExtension() Get the file extension for template files.
 * @method static string runString(string $string, array $data = []) run the blade engine. It returns the result of the code.
 * @method static void directive(string $name, callable $handler) Register a handler for custom directives.
 * @method static void directiveRT(string $name, callable $handler) Register a handler for custom directives for run at runtime
 * @method static void setErrorFunction(callable $fn) It sets the callback function for errors. It is used by @error
 * @method static void setCanFunction(callable $fn) It sets the callback function for authentication. It is used by @can and @cannot
 * @method static void setAnyFunction(callable $fn) It sets the callback function for authentication. It is used by @canany
 */
class View extends Singleton
{
    /**
     * Create Blade instance.
     * @return \eftec\bladeone\BladeOne
     */
    protected static function createInstance()
    {
        $templatePath = config('bladeone.template_path');
        $compiledPath = config('bladeone.compile_path');
        $mode = config('bladeone.mode');
        return new BladeOne($templatePath, $compiledPath, $mode);
    }
}
