<?php
namespace Apricot\Foundation;

/**
 * Improvised Translation Class
 */
class Translation
{
    /*
     * Messages
     */
    private $messages = [];

    /*
     * Create Translation
     * @param string $lang
     */
    public function __construct(string $lang='ja')
    {
        // Read Messages
        foreach(glob(assets_dir("lang/{$lang}/*.php")) as $file)
        {
            $arr = explode('.', basename($file));
            if (is_file($file)) $this->read($file, $arr[0]);
        }
    }

    /**
     * Checks if a key is present
     * @param string $key
     * @return bool
     */
    public function has(string $key):bool
    {
        return array_key_exists($key, $this->messages);
    }

    /**
     * Get a value from the Messages.
     * @param string $key
     * @param string $params
     * @return string
     */
    public function get(string $key, array $params = []):string
    {
        if ($this->has($key))
        {
            $message = $this->messages[$key];
            if (!empty($params))
            {
                $message = str_replace(array_keys($params), array_values($params), $message);
            }
        }
        else
        {
            $message = $key;
        }
        return $message;
    }

    /**
     * Read Messages
     * @param string $lang_file
     * @param string $top_key
     */
    private function read(string $lang_file, string $top_key)
    {
        $messages = require_once $lang_file;
        if (is_array($messages) && count($messages))
        {
            $dot_arr = array_dot($messages, $top_key.'.');
            $this->messages = array_merge($this->messages, $dot_arr);
        }
    }
}
