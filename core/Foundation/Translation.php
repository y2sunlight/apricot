<?php
namespace Apricot\Foundation;

/**
 * Plain Translation Class
 */
class Translation
{
    /**
     * @var string Language code(ISO 639-1)
     */
    private $lang;

    /**
     * @var array Messages
     */
    private $messages = [];

    /**
     * Constructor
     *
     * @param string $lang language code(ISO 639-1)
     */
    public function __construct(string $lang='en')
    {
        $this->lang = $lang;

        // Reads messages.
        foreach(glob(assets_dir("lang/{$lang}/*.php")) as $file)
        {
            $arr = explode('.', basename($file));
            if (is_file($file)) $this->read($file, $arr[0]);
        }
    }

    /**
     * Gets the language code(ISO 639-1).
     *
     * @return string
     */
    public function getLangCode():string
    {
        return $this->lang;
    }

    /**
     * Checks if the given key is present.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key):bool
    {
        return array_key_exists($key, $this->messages);
    }

    /**
     * Gets the message specified by the key.
     *
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
     * Reads messages.
     *
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
