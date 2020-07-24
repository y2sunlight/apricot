<?php
namespace Apricot\Foundation\Response;

use Apricot\Flash;
use Apricot\Foundation\ErrorBag;

/**
 * Redirecte Response Class
 */
class RedirectResponse extends \Apricot\Foundation\Response
{
    /**
     * Creates a redirect response.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->addHeader("Location: {$url}");
    }

    /**
     * Returns the instance of self with the specified flash data.
     *
     * @param string $key
     * @param mixed $value
     * @return RedirectResponse
     */
    public function with(string $key, $value):RedirectResponse
    {
        $this->addFlash($key, $value);
        return $this;
    }

    /**
     * Returns the instance of self with all input data as flash data.
     *
     * @return RedirectResponse
     */
    public function withInputs():RedirectResponse
    {
        $this->addFlash(self::FLASH_KEY_OLD, \Apricot\Input::getRawData());
        return $this;
    }

    /**
     * Returns the instance of self with the specified ErrorBag as flash data.
     *
     * @param  \Apricot\Foundation\ErrorBag $message
     * @return RedirectResponse
     */
    public function withErrors(ErrorBag $errorBag):RedirectResponse
    {
        $this->addFlash(self::FLASH_KEY_ERRORS, $errorBag);
        return $this;
    }

    /**
     * Returns the instance of self with the previous ErrorBag as flash data.
     *
     * @return RedirectResponse
     */
    public function withOldErrors():RedirectResponse
    {
        if (Flash::has(self::FLASH_KEY_ERRORS))
        {
            $this->addFlash(self::FLASH_KEY_ERRORS, Flash::get(self::FLASH_KEY_ERRORS));
        }
        return $this;
    }
}