<?php

namespace Symart\IndexBundle\DTO;

class Page
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $html;

    /**
     * @return string
     */
    public function getHost() : string
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @return $this
     */
    public function setHost(string $host) : Page
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getHtml() : string
    {
        return $this->html;
    }

    /**
     * @param string $html
     *
     * @return $this
     */
    public function setHtml(string $html) : Page
    {
        $this->html = $html;

        return $this;
    }
}
