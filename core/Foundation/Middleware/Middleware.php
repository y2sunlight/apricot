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
     * Processes an incoming request and produces a response.
     *
     * @param Invoker $next Next invoker.
     * @return \Apricot\Foundation\Response if return a response within this method, then don't call the next action.
     */
    public function process(Invoker $next) :Response;
}