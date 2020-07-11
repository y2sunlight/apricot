<?php
namespace Apricot\Foundation;

/**
 * Very Simple Input Class
 */
class SimpleInput
{
    /**
     * SimpleInput Data
     * @var array
     */
    private $input = null;

    /**
     * Create Simple Input
     */
    public function __construct(array $input=null)
    {
        $this->input = !empty($input) ? $input : array();
    }

    /**
     * Checks if a key is present
     * @param string $key
     * @return boolean
     */
    public function has(string $key):bool
    {
        return array_key_exists($key, $this->input);
    }

    /**
     * Get input data
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function get(string $key, string $default = null)
    {
        if ($this->has($key))
        {
            return $this->input[$key];
        }
        else
        {
            return $default;
        }
    }

    /**
     * Get all input data
     * @return array
     */
    public function all():array
    {
        return $this->input;
    }

    /**
     * Get a subset of the input for only specified keys
     * @param array|mixed $keys array or arguments list
     * @return array
     */
    public function only($keys):array
    {
        $key_arr = is_array($keys) ? $keys : func_get_args();
        return array_only($this->input, $key_arr);
    }

    /**
     * Get a subset of the input except for specified keys
     * @param array|mixed $keys array or arguments list
     * @return array
     */
    public function except($keys):array
    {
        $key_arr = is_array($keys) ? $keys : func_get_args();
        return array_except($this->input, $key_arr);
    }

    /**
     * Set input data
     * @param string $key
     * @param string $value
     */
    public function set(string $key, string $value)
    {
        $this->input[$key] = $value;
    }

    /**
     * Remove input data
     * @param array|mixed $keys array or arguments list
     */
    public function remove($keys)
    {
        $key_arr = is_array($keys) ? $keys : func_get_args();
        foreach($key_arr as $key)
        {
            if ($this->has($key))
            {
                unset($this->input[$key]);
            }
        }
    }
}
