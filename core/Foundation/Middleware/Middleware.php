<?php
namespace Core\Foundation\Middleware;

use Core\Foundation\Invoker;
use Core\Foundation\Response;

/**
 * Middleware Interface
 */
interface Middleware
{
    /**
     * Process incoming requests and produces a response
     * @param Invoker $next Next invoker
     * @return \Core\Foundation\Response if return response, then don'true call next action
     */
    public function process(Invoker $next) :Response;
}