<?php
namespace Apricot\Foundation;

/**
 * Plain Configuration Class
 */
class Configuration
{
    /**
     * @var array configuration data
     */
    protected $config = [];

    /**
     * Constructor
     */
    function __construct()
    {
        // Reads Configuration
        foreach(glob(config_dir("setting/*.setting.php")) as $file)
        {
            $arr = explode('.', basename($file));
            if (is_file($file)) $this->read($file, $arr[0]);
        }
    }

    /**
     * Checks if the given key is present.
     *
     * @param string $dot Dot-notation key
     * @return bool
     */
    public function has(string $dot):bool
    {
        return array_has($this->config, $dot);
    }

    /**
     * Gets the configuration value specified by the Dot-notation key.
     *
     * @param string $dot Dot-notation key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $dot, $default = null)
    {
        return array_get($this->config, $dot, $default);
    }

    /**
     * Reads configuration data.
     *
     * @param string $config_file
     * @param string $top_key
     */
    private function read(string $config_file, string $top_key)
    {
        $config = require_once $config_file;
        if (is_array($config) && count($config))
        {
            $this->config[$top_key] = $config;
        }
    }
}