<?php
namespace Core\Foundation;

/**
 * Invoker Interface
 */
interface Invoker
{
    /**
     * Invoke incoming request processor
     * @return \Core\Foundation\Response
     */
    public function invoke() : Response;
}