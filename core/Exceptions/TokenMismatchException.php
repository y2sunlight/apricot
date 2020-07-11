<?php
namespace Apricot\Exceptions;

/**
 * Token Mismatch Exception
 */
class TokenMismatchException extends \Exception
{
    /**
     * Create TokenMismatchException
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct(string $message = 'Token Mismatch Exception', int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

