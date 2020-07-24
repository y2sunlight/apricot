<?php
/**
 * Adds a subpath to the base path.
 *
 * @param string $base Base path
 * @param string $path Sub path, if necessary
 * @return string path
 */
function add_path(string $base, string $path = null) : string
{
    return (is_null($path)) ? $base : rtrim($base,'/').'/'.$path;
}

/**
 * Converts a multi-dimensional associative array to a dot-notation array.
 *
 * @param  array   $hash multi-dimensional associative array
 * @param  string  $prepend
 * @return array   a dot-notation array
 */
function array_dot(array $hash, $prepend = '')
{
    $dot_arry = [];
    foreach ($hash as $key => $value)
    {
        if (is_array($value) && count($value))
        {
            $dot_arry = array_merge($dot_arry, array_dot($value, $prepend.$key.'.'));
        }
        else
        {
            $dot_arry[$prepend.$key] = $value;
        }
    }
    return $dot_arry;
}

/**
 * Gets an item from an array using dot-notation.
 *
 * @param  array $hash multi-dimensional associative array
 * @param  string $dot key using Dot-notation
 * @param  mixed $default
 * @return mixed
 */
function array_get(array $hash, string $dot=null, $default=null)
{
    if (!isset($dot)) return $hash;

    $keys = explode('.', $dot);
    foreach($keys as $key)
    {
        if (array_key_exists($key, $hash))
        {
            $hash = $hash[$key];
        }
        else
        {
            return $default;
        }
    }
    return $hash;
}

/**
 * Checks if a key is present in an array using dot-notation.
 *
 * @param  array $hash multi-dimensional associative array
 * @param  string $dot key using Dot-notation
 * @return bool
 */
function array_has(array $hash, string $dot):bool
{
    $keys = explode('.', $dot);
    foreach($keys as $key)
    {
        if (array_key_exists($key, $hash))
        {
            $hash = $hash[$key];
        }
        else
        {
            return false;
        }
    }
    return true;
}

/**
 * Gets a subset of inputs for the specified item only.
 *
 * @param array $input
 * @param array|mixed $keys
 * @return array subset of the input
 */
function array_only(array $input, $keys)
{
    $key_arr = is_array($keys) ? $keys : array_slice(func_get_args(),1);

    $results = [];
    foreach ($key_arr as $key)
    {
        $results[$key] = $input[$key];
    }
    return $results;
}

/**
 * Gets a subset of the inputs except specified items.
 *
 * @param array $input
 * @param array|mixed $keys
 * @return array subset of the input
 */
function array_except(array $input, $keys=null)
{
    $key_arr = is_array($keys) ? $keys : array_slice(func_get_args(),1);

    $results = [];
    foreach($input as $key=>$value)
    {
        if (!in_array($key,$key_arr)) $results[$key]=$value;
    }
    return $results;
}

/**
 * This function generates a random number.
 *
 * @param number $length
 * @return string
 */
function str_random($length = 32)
{
    return substr(bin2hex(random_bytes($length)), 0, $length);
}

/**
 * Gets the short class name.
 *
 * @param object $object
 * @return string
 */
function get_short_class_name($object)
{
    return (new \ReflectionClass($object))->getShortName();
}

/**
 * Converts the gived string(UpperCamelCase or lowerCamelCase) to snake_case.
 *
 * @param string $camel
 * @return string|null
 */
function snake_case(string $camel =null)
{
    if (!isset($camel)) return null;

    $snake = preg_replace('/([A-Z])/', '_$1', $camel);
    return ltrim(strtolower($snake), '_');
}

/**
 * Gets SQL text from a file.
 *
 * @param string $filename
 * @return array
 */
function file_get_sql(string $filename):array
{
    if (!file_exists($filename)) return [];

    // Read a file
    $text = file_get_contents($filename);
    $text = str_replace(["\r\n","\r"], "\n", $text);

    // Remove comment
    $text = preg_replace("/\/\*.*?\*\//s", '', $text);
    $text = preg_replace("/--.*?$/m", '', $text);

    // Split SQL text
    $sql = preg_split("/\s*;\s*/", $text);
    array_walk($sql, function(&$item){
        $item = trim($item);
    });
    $sql = array_filter($sql, function($val){
        return !empty(trim($val));
    });
    return $sql;
}

/**
 * This function copies directories recursively.
 *
 * @param string $src source directory
 * @param string $dst destination directory
 */
function recursive_copy(string $src, string $dst)
{
    if (!file_exists($dst))
    {
        if (@mkdir($dst) === false) return;
    }

    $dir = @opendir($src);
    if($dir === false) return;

    while(false !== ($file = @readdir($dir)))
    {
        if(($file != '.')&&($file != '..'))
        {
            $src_file = "{$src}/{$file}";
            $dst_file = "{$dst}/{$file}";
            if(is_dir($src_file) && is_readable($src_file))
            {
                recursive_copy($src_file, $dst_file);
            }
            elseif(is_file($src_file) && is_writable($dst))
            {
                @copy($src_file, $dst_file);
            }
        }
    }
    @closedir($dir);
}
