<?php

namespace Symart\IndexBundle\Tests;

use Symart\IndexBundle\Controller\HomeController;
use Symart\IndexBundle\Fetcher\FetcherInterface;
use Symart\IndexBundle\Parser\ParserResolverInterface;
use Symart\IndexBundle\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testWelcome()
    {
        /** @var FetcherInterface | \PHPUnit_Framework_MockObject_MockObject $fetcher */
        $fetcher = $this->getMock(FetcherInterface::class);

        /** @var ParserResolverInterface $parserResolver */
        $parserResolver = $this->getMock(ParserResolverInterface::class);

        /** @var ProductRepository $productRepository */
        $productRepository = $this->getMockBuilder(ProductRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fetcher->method('fetchPages')->with([])->willReturn([]);

        $controller = new HomeController($fetcher, $parserResolver, $productRepository);
        $response = $controller->welcome();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}
