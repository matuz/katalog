<?php

namespace Symart\IndexBundle\Tests\Fetcher;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Fetcher\HttpFetcher;

class GuzzleFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpFetcher
     */
    private $fetcher;

    /**
     * @var ClientInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $client;

    public function setUp()
    {
        $this->client = $this->getMock(ClientInterface::class);
        $this->fetcher = new HttpFetcher($this->client);
    }

    public function testFetcher()
    {
        //given
        $this->client->method('request')->will(
            $this->returnValueMap([
                ['GET', 'http://test.org/page1', [], $this->getResponse('page1')],
                ['GET', 'http://test.org/page2', [], $this->getResponse('page2')],
                ['GET', 'http://test.org/page3', [], $this->getResponse('page3')],
            ]
        ));

        //when
        $pages = $this->fetcher->fetchPages(
            ['http://test.org/page1', 'http://test.org/page2', 'http://test.org/page3']
        );

        //then
        $this->assertContains(
            (new Page())->setHtml('page1_content')->setHost('http://test.org'),
            $pages,
            'page 1 not exist',
            false,
            false
        );
        $this->assertContains(
            (new Page())->setHtml('page2_content')->setHost('http://test.org'),
            $pages,
            'page 2 not exist',
            false,
            false
        );
        $this->assertContains(
            (new Page())->setHtml('page3_content')->setHost('http://test.org'),
            $pages,
            'page 3 not exist',
            false,
            false
        );
    }

    /**
     * @param string $pageName
     * @return \PHPUnit_Framework_MockObject_MockObject|ResponseInterface
     */
    private function getResponse(string $pageName) : ResponseInterface
    {
        /** @var ResponseInterface | \PHPUnit_Framework_MockObject_MockObject $mock */
        $mock = $this->getMock(ResponseInterface::class);

        $stream = $this->getMock(StreamInterface::class);
        $stream->method('getContents')->willReturn($pageName . '_content');

        $mock->method('getBody')->willReturn($stream);

        return $mock;
    }
}
