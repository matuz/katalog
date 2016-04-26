<?php

namespace Symart\IndexBundle\Tests\Parser;

use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;
use Symart\IndexBundle\Parser\DrecottonParser;

class DrecottonParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DrecottonParser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = new DrecottonParser();
    }

    public function tearDown()
    {
        unset($this->parser);
    }

    public function testIndexPage()
    {
        $html = file_get_contents(__DIR__ . '/html/drecotton.index.html');

        $p1 = (new Product())
            ->setImage('http://drecotton.pl/6429-large_default/bawelna-100-batyst-granatowo-niebieskie-ptaszki-kwiatki.jpg')
            ->setUrl('http://drecotton.pl/pl/tkaniny/2330-bawelna-100-batyst-granatowo-niebieskie-ptaszki-kwiatki-452.html');
        $p2 = (new Product())
            ->setImage('http://drecotton.pl/6427-large_default/bawelna-100-naszkicowane-lesne-zwierzeta-na-kremowym-tle.jpg')
            ->setUrl('http://drecotton.pl/pl/tkaniny/2329-bawelna-100-naszkicowane-lesne-zwierzeta-na-kremowym-tle-557.html');
        $p3 = (new Product())
            ->setImage('http://drecotton.pl/6424-large_default/bawelna-100-klosy-szare.jpg')
            ->setUrl('http://drecotton.pl/pl/tkaniny/2328-bawelna-100-klosy-szare-557.html');

        $expected = [$p1, $p2, $p3];

        $page = (new Page())->setHost('http://drecotton.pl')->setHtml($html);

        $productUrls = $this->parser->parseIndexPage($page);

        $this->assertEquals($expected, $productUrls);
    }
}