<?php

namespace Symart\IndexBundle\Tests\Parser;

use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;
use Symart\IndexBundle\Parser\MamaFabricsParser;

class MamaFabricsParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MamaFabricsParser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = new MamaFabricsParser();
    }

    public function tearDown()
    {
        unset($this->parser);
    }

    public function testParseIndexPage()
    {
        $html = file_get_contents(__DIR__ . '/html/mamafabrics.index.html');

        $p1 = (new Product())
            ->setImage('http://www.mamafabrics.pl/environment/cache/images/300_300_productGfx_55f189409647185a6f8e7674bd99b809.jpg')
            ->setUrl('http://www.mamafabrics.pl/pl/p/Cats-Marsala-0%2C51x1%2C58m/161');
        $p2 = (new Product())
            ->setImage('http://www.mamafabrics.pl/environment/cache/images/300_300_productGfx_74b4914b4bc26bd5227fe3014a594522.jpg')
            ->setUrl('http://www.mamafabrics.pl/pl/p/Cats-Powder-concrete-1%2C5x0%2C46m/153');
        $p3 = (new Product())
            ->setImage('http://www.mamafabrics.pl/environment/cache/images/300_300_productGfx_489d95f566243df7d51f5b39ee109ee6.jpg')
            ->setUrl('http://www.mamafabrics.pl/pl/p/Cats-Powder-Lemon-0%2C96x0%2C74m/152');
        
        $expected = [$p1, $p2, $p3];

        $page = (new Page())->setHost('http://www.mamafabrics.pl')->setHtml($html);

        $productUrls = $this->parser->parseIndexPage($page);

        $this->assertEquals($expected, $productUrls);
    }
}
