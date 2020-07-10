<?php
namespace Core\Foundation;

/**
 * Improvised Configuration Class
 */
class Configuration
{
    /**
     * Configurations
     * @var array
     */
    protected $config = [];

    /**
     * Create Configuration
     */
    function __construct()
    {
        // Read Configuration
        foreach(glob(config_dir("setting/*.setting.php")) as $file)
        {
            $arr = explode('.', basename($file));
            if (is_file($file)) $this->read($file, $arr[0]);
        }
    }

    /**
     * Checks if a key is present
     * @param string $dot Dot-notation key
     * @return bool
     */
    public function has(string $dot):bool
    {
        return array_has($this->config, $dot);
    }

    /**
     * Get a value from the configuration
     * @param string $dot Dot-notation key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $dot, $default = null)
    {
        return array_get($this->config, $dot, $default);
    }

    /**
     * Read configuration
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