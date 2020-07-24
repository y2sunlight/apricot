<?php
namespace Apricot\Exceptions;

/**
 * Token mismatch exception
 */
class TokenMismatchException extends \Exception
{
    /**
     * Creates a token mismatch exception.
     *
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct(string $message = 'Token Mismatch Exception', int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

