<?php
namespace Apricot\Exceptions;

/**
 * HTTP exception
 */
class HttpException extends \Exception
{
    /**
     * @var int HTTP response status code
     */
    private $statusCode;

    /**
     * Creates a HTTP exception.
     *
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
     * Gets the HTTP response status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
