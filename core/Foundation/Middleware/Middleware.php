<?php
namespace Apricot\Foundation\Middleware;

use Apricot\Foundation\Invoker;
use Apricot\Foundation\Response;

/**
 * Middleware Interface
 */
interface Middleware
{
    /**
     * Process incoming requests and produces a response
     * @param Invoker $next Next invoker
     * @return \Apricot\Foundation\Response if return response, then don'true call next action
     */
    public function process(Invoker $next) :Response;
}