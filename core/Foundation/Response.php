<?php
namespace Apricot\Foundation;

use Apricot\Session;

/**
 * Improvised Response Class
 */
class Response
{
    /**
     *
     * @var array
     */
    protected $headers = [];

    /**
     *
     * @var array
     */
    protected $flashes = [];

    /**
     * Flash key for old inputs
     */
    public const FLASH_KEY_OLD = '_old_inputs';

    /**
     * Flash key for old URL Path
     */
    public const FLASH_KEY_BACK = '_old_path';

    /**
     * Flash key for error bag
     */
    public const FLASH_KEY_ERRORS = 'errors';

    /**
     * Add a header
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
     * Check if a flash value is present
     * @param string $key
     * @return bool
     */
    public function hasFlash(string $key):bool
    {
        return array_key_exists($key, $this->flashes);
    }

    /**
     * Add a value to flash
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
     * Commit Response Data
     * @param int $response_code
     */
    public function commit(int $response_code=null)
    {
        if (!headers_sent())
        {
            // Set Http response code
            if (isset($response_code))
            {
                http_response_code($response_code);
            }

            // Output headers
            foreach($this->headers as $header)
            {
                header($header);
            }
        }

        // Save old URL Path
        $this->addFlash(self::FLASH_KEY_BACK, $_SERVER['REQUEST_URI']);

        // Output flashes
        foreach($this->flashes as $key=>$value)
        {
            Session::flash()->set($key, $value);
        }
    }
}