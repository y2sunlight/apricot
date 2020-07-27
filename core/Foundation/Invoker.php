<?php
namespace Apricot\Foundation;

/**
 * Invoker Interface
 */
interface Invoker
{
    /**
     * Invokes an incoming request processor
     *
     * @return \Apricot\Foundation\Response
     */
    public function invoke() : Response;
}