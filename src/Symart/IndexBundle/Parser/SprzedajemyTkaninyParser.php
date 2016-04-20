<?php
/**
 * Created by PhpStorm.
 * User: symart
 * Date: 17.04.16
 * Time: 10:37
 */

namespace Symart\IndexBundle\Parser;

use pQuery;
use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;

class SprzedajemyTkaninyParser implements ParserInterface
{

    /**
     * @param Page $page
     *
     * @return array|Product[]
     */
    public function parseIndexPage(Page $page)
    {
        $pageContent = pQuery::parseStr($page->getHtml());

        $divs = $pageContent->query('#box_mainproducts .product');

        $result = [];
        /** @var pQuery\DomNode $div */
        foreach ($divs as $div) {
            $result[] = (new Product())
                ->setUrl($page->getHost() . $div->query('a.prodimage')->attr('href'))
                ->setImage($page->getHost() . $div->query('span.img-wrap img')->attr('data-src'));
        }

        return $result;
    }

    /**
     * @param Page $page
     *
     * @return bool
     */
    public function support(Page $page)
    {
        return $page->getHost() === 'http://www.sprzedajemytkaniny.pl';
    }
}