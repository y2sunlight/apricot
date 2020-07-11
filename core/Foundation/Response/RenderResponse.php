<?php
namespace Apricot\Foundation\Response;

/*
 * Rendered Response Class
 */
class RenderResponse extends \Apricot\Foundation\Response
{
    /**
     * Html Data
     * @var string
     */
    private $html='';

    /**
     * Create RenderResponse
     * @param string $html
     * @param array $variables
     */
    public function __construct(string $html=null)
    {
        $this->setHtml($html);
    }

    /**
     * Set Html
     * @param string $html
     * @return RenderResponse
     */
    public function setHtml(string $html=null) : RenderResponse
    {
        if (isset($html)) $this->html = $html;
        return $this;
    }

    /**
     * commit
     * {@inheritDoc}
     * @see \Apricot\Foundation\Response::commit()
     */
    public function commit(int $response_code=null)
    {
        // headersに'Content-type'がなければ出力する
        $matchs= preg_grep('/^content-type.*?:/i', $this->headers);
        if(empty($matchs))
        {
            $this->addHeader("Content-type: text/html; charset=utf-8");
        }

        parent::commit($response_code);

        // HTMLのレンダリング
        echo $this->html;
        flush();
    }

}