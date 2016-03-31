<?php

namespace Symart\IndexBundle\Tests\Parser;

use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;
use Symart\IndexBundle\Parser\DresowkaParser;

class DresowkaParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DresowkaParser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = new DresowkaParser();
    }

    public function tearDown()
    {
        unset($this->parser);
    }
    
    public function testIndexPage()
    {
        $html = file_get_contents(__DIR__ . '/html/dresowka.index.html');

        $p1 = (new Product())
            ->setImage('http://dresowka.pl/environment/cache/images/200_150_productGfx_55d33695211c0c896396720252019f74.jpg')
            ->setUrl('http://dresowka.pl/pl/p/KOALA/6117');
        $p2 = (new Product())
            ->setImage('http://dresowka.pl/environment/cache/images/200_150_productGfx_be5b442ba189e8689f0f8281201a5498.jpg')
            ->setUrl('http://dresowka.pl/pl/p/KOALA-Paski/6118');
        $p3 = (new Product())
            ->setImage('http://dresowka.pl/environment/cache/images/200_150_productGfx_9c96669d2860904085de3aa805d2dbe4.jpg')
            ->setUrl('http://dresowka.pl/pl/p/KOALA-Mietowa/6119');

        $expected = [$p1, $p2, $p3];

        $page = (new Page())->setHost('http://dresowka.pl')->setHtml($html);

        $productUrls = $this->parser->parseIndexPage($page);

        $this->assertEquals($expected, $productUrls);
    }
}
