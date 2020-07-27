<?php
namespace Apricot\Foundation;

use Apricot\Session;

/**
 * Plain Response Base Class
 */
class Response
{
    /**
     * @var array Response headers
     */
    protected $headers = [];

    /**
     * @var array flash data
     */
    protected $flashes = [];

    /**
     *  @var string Flash key for old inputs
     */
    public const FLASH_KEY_OLD = '_old_inputs';

    /**
     * @var string Flash key for old URL Path
     */
    public const FLASH_KEY_BACK = '_old_path';

    /**
     * @var string Flash key for error bag
     */
    public const FLASH_KEY_ERRORS = 'errors';

    /**
     * Adds one or more headers.
     *
     * @param string|array $headers
     * @return Response
     */
    public function addHeader($headers):Response
    {
        $header_arr = is_array($headers) ? $headers : [$headers];
        foreach($header_arr as $header)
        {
            $this->headers[] = $header;
        }
        return $this;
    }

    /**
     * Checks if the given key in flash data is present.
     *
     * @param string $key
     * @return bool
     */
    public function hasFlash(string $key):bool
    {
        return array_key_exists($key, $this->flashes);
    }

    /**
     * Adds a value to flash.
     *
     * @param string $key
     * @param mixed $value
     * @return Response
     */
    public function addFlash(string $key, $value):Response
    {
        $this->flashes[$key] = $value;
        return $this;
    }

    /**
     * Commits response data.
     *
     * @param int $response_code
     */
    public function commit(int $response_code=null)
    {
        if (!headers_sent())
        {
            // Sets a Http response code.
            if (isset($response_code))
            {
                http_response_code($response_code);
            }

            // Outputs headers.
            foreach($this->headers as $header)
            {
                header($header);
            }
        }

        // Saves old URL Path.
        $this->addFlash(self::FLASH_KEY_BACK, $_SERVER['REQUEST_URI']);

        // Outputs flashes.
        foreach($this->flashes as $key=>$value)
        {
            Session::flash()->set($key, $value);
        }
    }
}