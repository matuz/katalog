<?php

namespace Symart\IndexBundle\Parser;

use pQuery;
use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;

class DresowkaParser implements ParserInterface
{

    /**
     * @param Page $page
     *
     * @return array|Product[]
     */
    public function parseIndexPage(Page $page)
    {
        $obj = json_decode($page->getHtml(), true);

        $pageContent = pQuery::parseStr($obj['productList']);

        $divs = $pageContent->query('.product_list .product-image-container');

        $result = [];
        /** @var pQuery\DomNode $div */
        foreach ($divs as $div) {
            $result[] = (new Product())
                ->setUrl($page->getHost() . $div->query('a.product_img_link')->attr('href'))
                ->setImage($div->query('img')->attr('src'));
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
        return $page->getHost() === 'http://dresowka.pl';
    }
}
