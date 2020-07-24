<?php

namespace App\Exceptions;

/**
 * Optimisstic Lock Exception
 */
class OptimissticLockException extends ApplicationException
{
    /**
     * Creates an optimisstic lock exception.
     *
     * @param string $message
     * @param \Exception $previous
     */
    public function __construct()
    {
        parent::__construct(__('messages.error.db.optimisstic_lock'), __CLASS__);
    }
}
