<?php

namespace App\Exceptions;

/**
 * 楽観的ロック例外
 */
class OptimissticLockException extends ApplicationException
{
    /**
     * Create Optimisstic Lock
     * @param string $message
     * @param \Exception $previous
     */
    public function __construct()
    {
        parent::__construct(__('messages.error.db.optimisstic_lock'), __CLASS__);
    }
}
