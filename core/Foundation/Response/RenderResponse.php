<?php
namespace Apricot\Foundation\Response;

/*
 * Render Response Class
 */
class RenderResponse extends \Apricot\Foundation\Response
{
    /**
     * @var string Html text
     */
    private $html='';

    /**
     * Creates a render response.
     *
     * @param string $html
     */
    public function __construct(string $html=null)
    {
        $this->setHtml($html);
    }

    /**
     * Sets Html text.
     *
     * @param string $html
     * @return RenderResponse
     */
    public function setHtml(string $html=null) : RenderResponse
    {
        if (isset($html)) $this->html = $html;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Apricot\Foundation\Response::commit()
     */
    public function commit(int $response_code=null)
    {
        // Adds 'Content-type' header if headers does not have'Content-type'.
        $matchs= preg_grep('/^content-type.*?:/i', $this->headers);
        if(empty($matchs))
        {
            $this->addHeader("Content-type: text/html; charset=utf-8");
        }

        parent::commit($response_code);

        // Renders HTML.
        echo $this->html;
        flush();
    }

}