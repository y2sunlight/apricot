<?php
namespace Apricot\Foundation;

/**
 * Invoker Interface
 */
interface Invoker
{
    /**
     * Invoke incoming request processor
     * @return \Apricot\Foundation\Response
     */
    public function invoke() : Response;
}