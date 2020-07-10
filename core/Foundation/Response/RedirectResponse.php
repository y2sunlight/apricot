<?php
namespace Core\Foundation\Response;

use Core\Flash;
use Core\Foundation\ErrorBag;

/**
 * Redirected Response Class
 */
class RedirectResponse extends \Core\Foundation\Response
{
    /**
     * Create RedirectResponse
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->addHeader("Location: {$url}");
    }

    /**
     * with
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
     * withInputs
     * @return RedirectResponse
     */
    public function withInputs():RedirectResponse
    {
        $this->addFlash(self::FLASH_KEY_OLD, \Core\Input::getRawData());
        return $this;
    }

    /**
     * withErrors
     * @param  \Core\Foundation\ErrorBag $message
     * @return RedirectResponse
     */
    public function withErrors(ErrorBag $errorBag):RedirectResponse
    {
        $this->addFlash(self::FLASH_KEY_ERRORS, $errorBag);
        return $this;
    }

    /**
     * withOldErrors
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