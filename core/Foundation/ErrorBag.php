<?php
namespace Apricot\Foundation;

/**
 * Error Bag Class
 */
class ErrorBag implements \IteratorAggregate
{
    /** @var string Default error bag name */
    public const DEFAULT_NAME = 'error';

    /** @var string Bag name */
    private $name;

    /** @var array Errors */
    private $errors = [];

    /**
     * Creates a error bag.
     *
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
     * Counts errors.
     *
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
     * Checks if the given key is present.
     *
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
     * Gets the error specified by the key.
     *
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
     * Gets all errors.
     *
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
     * Puts errors.
     *
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
