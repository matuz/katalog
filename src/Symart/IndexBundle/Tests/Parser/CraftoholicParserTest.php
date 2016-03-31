<?php

namespace Symart\IndexBundle\Tests\Parser;

use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;
use Symart\IndexBundle\Parser\CraftoholicParser;

class CraftoholicParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CraftoholicParser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = new CraftoholicParser();
    }

    public function tearDown()
    {
        unset($this->parser);
    }

    public function testIndexPage()
    {
        $html = file_get_contents(__DIR__ . '/html/craftoholic.index.html');

        $p1 = (new Product())
            ->setImage('http://craftoholicshop.com/environment/cache/images/0_150_productGfx_40e5b1b967e794fd002bdb8c6de41ecf.jpg')
            ->setUrl('http://craftoholicshop.com/pl/p/Tkanina-Crazy-Hens-Garden-Robert-Kaufman-/2133');
        $p2 = (new Product())
            ->setImage('http://craftoholicshop.com/environment/cache/images/0_150_productGfx_d60caa9528970e02a348bfb82497dec4.jpg')
            ->setUrl('http://craftoholicshop.com/pl/p/Tkanina-Kurczaczki-Spring-Robert-Kaufman/557');
        $p3 = (new Product())
            ->setImage('http://craftoholicshop.com/environment/cache/images/0_150_productGfx_1c5b05a3d65b0a890b20b686d4dcfee8.jpg')
            ->setUrl('http://craftoholicshop.com/pl/p/Tkanina-Tweet-Coral-Michael-Miller/1431');

        $expected = [$p1, $p2, $p3];

        $page = (new Page())->setHost('http://craftoholicshop.com')->setHtml($html);

        $productUrls = $this->parser->parseIndexPage($page);

        $this->assertEquals($expected, $productUrls);
    }
}
