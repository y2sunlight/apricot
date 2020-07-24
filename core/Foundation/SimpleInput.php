<?php
namespace Apricot\Foundation;

/**
 * Simple Input Class
 */
class SimpleInput
{
    /**
     * @var array input data
     */
    private $input = null;

    /**
     * Creates input data.
     */
    public function __construct(array $input=null)
    {
        $this->input = !empty($input) ? $input : array();
    }

    /**
     * Checks if the given key is present.
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key):bool
    {
        return array_key_exists($key, $this->input);
    }

    /**
     * Gets the input data specified by the key.
     *
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
     * Gets all input data.
     *
     * @return array
     */
    public function all():array
    {
        return $this->input;
    }

    /**
     * Gets a subset of inputs for the specified keys only.
     *
     * @param array|mixed $keys array or arguments list
     * @return array
     */
    public function only($keys):array
    {
        $key_arr = is_array($keys) ? $keys : func_get_args();
        return array_only($this->input, $key_arr);
    }

    /**
     * Gets a subset of inputs except specified keys.
     *
     * @param array|mixed $keys array or arguments list
     * @return array
     */
    public function except($keys):array
    {
        $key_arr = is_array($keys) ? $keys : func_get_args();
        return array_except($this->input, $key_arr);
    }

    /**
     * Sets input data.
     *
     * @param string $key
     * @param string $value
     */
    public function set(string $key, string $value)
    {
        $this->input[$key] = $value;
    }

    /**
     * Removes the input data specified by the key.
     *
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
