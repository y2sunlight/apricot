<?php

namespace App\Exceptions;

/**
 * アプリケーション例外
 */
class ApplicationException extends \Exception
{
    /**
     * User error message
     * @var string
     */
    private $user_message;

    /**
     * Create ApplicationException
     * @param string $user_message
     * @param string $internal_message
     * @param int $code
     * @param \Throwable $previous
     */
    public function __construct(string $user_message=null, $internal_message=__CLASS__, int $code = 0, \Throwable $previous = null)
    {
        $this->user_message = isset($user_message) ? $user_message : __('messages.error.unknown');
        parent::__construct($internal_message, $code, $previous);
    }

    /**
     * Get user error message
     * @return string
     */
    public function getUserMessage()
    {
        return $this->user_message;
    }
}
