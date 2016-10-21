<?php

namespace Symart\IndexBundle\Fetcher;

use GuzzleHttp\ClientInterface;
use Symart\IndexBundle\DTO\Page;

class HttpFetcher implements FetcherInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $guzzle
     */
    public function __construct(ClientInterface $guzzle)
    {
        $this->client = $guzzle;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchPages(array $pageList = array()) : array
    {
        $pages = [];

        foreach ($pageList as $url) {
            $parsedUrl = parse_url($url);
            $response = $this->client->request('GET', $url);

            $page = (new Page())->setHost($parsedUrl['scheme'] . '://' . $parsedUrl['host'])->setHtml(
                $response->getBody()->getContents()
            );

            $pages[] = $page;
        }

        return $pages;
    }
}
