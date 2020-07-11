<?php
namespace Apricot\Exceptions;

/**
 * Http Exception
 */
class HttpException extends \Exception
{
    /**
     * Http Status Code
     * @var int
     */
    private $statusCode;

    /**
     * Create HttpException
     * @param int $statusCode
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct(int $statusCode, string $message = null, int $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $statusCode;
        parent::__construct(isset($message) ? $message : "Http Status : {$statusCode}", $code, $previous);
    }

    /**
     * Get Http Status Code
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
