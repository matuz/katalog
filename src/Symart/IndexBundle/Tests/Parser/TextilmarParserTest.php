<?php

namespace Symart\IndexBundle\Tests\Parser;

use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;
use Symart\IndexBundle\Parser\TextilmarParser;

class TextilmarParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TextilmarParser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = new TextilmarParser();
    }

    public function tearDown()
    {
        unset($this->parser);
    }

    public function testParseIndexPage()
    {
        $html = file_get_contents(__DIR__ . '/html/textilmar.index.html');

        $p1 = (new Product())
            ->setImage('http://sklep.textilmar.pl/images/produkty/200x135/D1_128_30B.jpg')
            ->setUrl('http://sklep.textilmar.pl/dzianina-dresowa-wzor-dzianina-dresowa-army-dusty-green-p-9264.html');
        $p2 = (new Product())
            ->setImage('http://sklep.textilmar.pl/images/produkty/200x135/D1_128_31B.jpg')
            ->setUrl('http://sklep.textilmar.pl/dzianina-dresowa-wzor-dzianina-dresowa-army-turtle-green-p-9265.html');
        $p3 = (new Product())
            ->setImage('http://sklep.textilmar.pl/images/produkty/200x135/D1_128_6B.jpg')
            ->setUrl('http://sklep.textilmar.pl/dzianina-dresowa-wzor-dzianina-dresowa-bomb-p-9130.html');
        
        $expected = [$p1, $p2, $p3];

        $page = (new Page())->setHost('http://sklep.textilmar.pl')->setHtml($html);

        $productUrls = $this->parser->parseIndexPage($page);

        $this->assertEquals($expected, $productUrls);
    }
}
