<?php
namespace Core\Foundation;

/**
 * Error Bag Class
 */
class ErrorBag implements \IteratorAggregate
{
    public const DEFAULT_NAME = 'error';

    /**
     * Bag name
     * @var string
     */
    private $name;

    /**
     * Errors
     * @var array
     */
    private $errors = [];

    /**
     * Create Error bag
     * @param array $errors Associative array
     * @param string $name Bag name
     */
    public function __construct($errors=null, string $name=self::DEFAULT_NAME)
    {
        $this->name = $name;
        if (isset($errors))
        {
            $this->put($errors);
        }
    }

    /**
     * Count errors
     * @param string $name Bag name
     * @return int
     */
    public function count(string $name=null):int
    {
        if (!isset($name) || ($this->name==$name))
        {
            return count($this->errors);
        }
        else
        {
            return 0;
        }
    }

    /**
     * Checks if a key is present
     * @param string $key Error key
     * @param string $name Bag name
     * @return boolean
     */
    public function has(string $key, string $name=self::DEFAULT_NAME):bool
    {
        if ($this->name==$name)
        {
            return array_key_exists($key, $this->errors);
        }
        return false;
    }

    /**
     * Get error a bag
     * @param string $key Error key
     * @param string $name Bag name
     * @return mixed return null if a key is not present
     */
    public function get(string $key, string $name=self::DEFAULT_NAME)
    {
        $result = null;
        if ($this->name==$name)
        {
            if ($this->has($key, $name))
            {
                return $this->errors[$key];
            }
        }
        return $result;
    }

    /**
     * Get all errors
     * @param string $name Bag name
     * @return array
     */
    public function all(string $name=null):array
    {
        if (!isset($name) || ($this->name==$name))
        {
            return $this->errors;
        }
        else
        {
            return [];
        }
    }

    /**
     * Put errors
     * @param array $error Associative array
     */
    public function put($errors)
    {
        $arr = is_array($errors) ? $errors : (array)$errors;
        $this->errors = $arr;
    }

    /**
     * IteratorAggregate Interface
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->errors);
    }
}
