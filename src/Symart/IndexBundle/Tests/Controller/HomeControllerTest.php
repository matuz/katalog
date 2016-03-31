<?php

namespace Symart\IndexBundle\Tests;

use Symart\IndexBundle\Controller\HomeController;
use Symart\IndexBundle\Fetcher\FetcherInterface;
use Symart\IndexBundle\Parser\ParserInterface;
use Symart\IndexBundle\Parser\ParserResolverInterface;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testWelcome()
    {
        /** @var FetcherInterface | \PHPUnit_Framework_MockObject_MockObject $fetcher */
        $fetcher = $this->getMock(FetcherInterface::class);

        /** @var ParserResolverInterface $parserResolver */
        $parserResolver = $this->getMock(ParserResolverInterface::class);

        $fetcher->method('fetchPages')->with([])->willReturn([]);

        $controller = new HomeController($fetcher, $parserResolver);
        $response = $controller->welcome();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}
