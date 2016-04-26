<?php

namespace Symart\IndexBundle\Tests\Parser;

use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;
use Symart\IndexBundle\Parser\OtulaParser;

class OtulaParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OtulaParser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = new OtulaParser();
    }

    public function tearDown()
    {
        unset($this->parser);
    }

    public function testIndexPage()
    {
        $html = file_get_contents(__DIR__ . '/html/otula.index.html');

        $p1 = (new Product())
            ->setImage('http://otula.pl/environment/cache/images/150_0_productGfx_c39f25fe20df05a02080ea2bb31773f9.jpg')
            ->setUrl('http://otula.pl/pl/p/Dzianina-140-g-Alice-karty-szachy-kot-gwiazdy-na-rozowym/2754');
        $p2 = (new Product())
            ->setImage('http://otula.pl/environment/cache/images/150_0_productGfx_9a35df51024b43ff46445b70c017562b.jpg')
            ->setUrl('http://otula.pl/pl/p/Dzianina-140-g-czaszki-czarne-na-szarym-bawelna/2530');
        $p3 = (new Product())
            ->setImage('http://otula.pl/environment/cache/images/150_0_productGfx_281917c3a05b16a6ae1ecd65fb598f18.jpg')
            ->setUrl('http://otula.pl/pl/p/Dzianina-140-g-kokardki-biale-na-koralowym-bawelna-/2671');

        $expected = [$p1, $p2, $p3];

        $page = (new Page())->setHost('http://otula.pl')->setHtml($html);

        $productUrls = $this->parser->parseIndexPage($page);

        $this->assertEquals($expected, $productUrls);
    }
}
