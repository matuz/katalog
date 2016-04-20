<?php
/**
 * Created by PhpStorm.
 * User: symart
 * Date: 17.04.16
 * Time: 10:29
 */

namespace Symart\IndexBundle\Tests\Parser;


use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;
use Symart\IndexBundle\Parser\SprzedajemyTkaninyParser;

class SprzedajemyTkaninyParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SprzedajemyTkaninyParser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = new SprzedajemyTkaninyParser();
    }

    public function tearDown()
    {
        unset($this->parser);
    }

    public function testIndexPage()
    {
        $html = file_get_contents(__DIR__ . '/html/sprzedajemytkaniny.index.html');

        $p1 = (new Product())
            ->setImage('http://www.sprzedajemytkaniny.pl/environment/cache/images/300_300_productGfx_e695a2ddd630c1b5f14cafdc44ee2b74.jpg')
            ->setUrl('http://www.sprzedajemytkaniny.pl/pl/p/Jasnoszare-choinki-na-bialym-tle-tkanina-bawelniana-Nowosc-/890');
        $p2 = (new Product())
            ->setImage('http://www.sprzedajemytkaniny.pl/environment/cache/images/300_300_productGfx_706f3e8ec9ad969a5fb8604921c07eaf.jpg')
            ->setUrl('http://www.sprzedajemytkaniny.pl/pl/p/Myszki-z-muszkamiwasami-tkanina-bawelniana-Nowosc-/654');
        $p3 = (new Product())
            ->setImage('http://www.sprzedajemytkaniny.pl/environment/cache/images/300_300_productGfx_9ee30af9c01932f9ccdd535fe1e5e9de.jpg')
            ->setUrl('http://www.sprzedajemytkaniny.pl/pl/p/Romby-czerwone-tkanina-bawelniana-/1208');

        $expected = [$p1, $p2, $p3];

        $page = (new Page())->setHost('http://www.sprzedajemytkaniny.pl')->setHtml($html);

        $productUrls = $this->parser->parseIndexPage($page);

        $this->assertEquals($expected, $productUrls);
    }
}