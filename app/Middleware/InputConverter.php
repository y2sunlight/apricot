<?php
namespace App\Middleware;

use Apricot\Foundation\Response;
use Apricot\Foundation\Invoker;
use Apricot\Foundation\Middleware\Middleware;
use Apricot\Input;

/**
 * Input Converter - Middleware
 */
class InputConverter implements Middleware
{
    /**
     * @var array List of input variables to exclude
     */
    private $exclude = [
        'password',
        'password_confirmation',
    ];

    /**
     * {@inheritDoc}
     * @see \Apricot\Foundation\Middleware\Middleware::invoke()
     */
    public function process(Invoker $next): Response
    {
        $inputs = Input::all();
        foreach($inputs as $key=>$value)
        {
            if (in_array($key, $this->exclude)) continue;
            if (is_string($value))
            {
                $value = trim($value); // Trims a string value.
                if($value === '') $value = null; // Converts an empty string value to null.
                Input::set($key, $value);
            }
        }
        return $next->invoke();
    }
}