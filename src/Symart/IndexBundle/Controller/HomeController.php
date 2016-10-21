<?php

namespace Symart\IndexBundle\Controller;

use Symart\IndexBundle\Entity\Product;
use Symart\IndexBundle\Fetcher\FetcherInterface;
use Symart\IndexBundle\Parser\ParserResolverInterface;
use Symart\IndexBundle\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    /**
     * @var FetcherInterface
     */
    private $fetcher;

    /**
     * @var ParserResolverInterface
     */
    private $parserResolver;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(FetcherInterface $fetcher, ParserResolverInterface $parserResolver, ProductRepository $productRepository)
    {
        $this->fetcher = $fetcher;
        $this->parserResolver = $parserResolver;
        $this->productRepository = $productRepository;
    }

    public function fetch(array $urls = [], string $uri) : Response
    {
        $pages = $this->fetcher->fetchPages($urls);

        $category = $this->productRepository->getCategory($uri);
        $this->productRepository->clearProductAssigments($category);

        foreach ($pages as $page) {
            /** @var Product[] $products */

            $parser = $this->parserResolver->getParser($page);
            $products = $parser->parseIndexPage($page);

            foreach ($products as $product) {
                $this->productRepository->ensureProduct($product);
                $this->productRepository->assignToCategory($category, $product);
            }
        }

        $text = 'DONE';

        return new Response($text, 200);

    }

    public function products(array $urls = []) : Response
    {
        $text = '';
        $pages = $this->fetcher->fetchPages($urls);
        $number = 0;

        foreach ($pages as $page) {
            /** @var Product[] $products */

            $parser = $this->parserResolver->getParser($page);
            $products = $parser->parseIndexPage($page);

            foreach ($products as $product) {
                ++$number;
                $text .= sprintf('<div style=\'width: 100px; height: 100px; border-radius: 50px; background: url(%s) no-repeat; background-position: center center; float: left; margin: 10px; \' >%d</div>', $product->getImage(), $number);
            }
        }

        return new Response($text, 200);
    }

    public function welcome(array $links = []) : Response
    {
        $text = '';

        foreach ($links as $link) {
            $text .= sprintf('<a href="%s" >%s</a><br>', $link, $link);
        }
        return new Response($text, 200);
    }
}
