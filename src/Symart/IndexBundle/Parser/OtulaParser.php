<?php

namespace Symart\IndexBundle\Parser;

use pQuery;
use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;

class OtulaParser implements ParserInterface
{
    /**
     * @param Page $page
     *
     * @return array|Product[]
     */
    public function parseIndexPage(Page $page)
    {
        $pageContent = pQuery::parseStr($page->getHtml());

        $divs = $pageContent->query('#box_mainproducts .innerbox .products .product');

        $result = [];
        /** @var pQuery\DomNode $div */
        foreach ($divs as $div) {
            $result[] = (new Product())
                ->setUrl($page->getHost() . $div->query('a.details')->attr('href'))
                ->setImage($page->getHost() . $div->query('img')->attr('src'));
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
        return $page->getHost() === 'http://otula.pl';
    }

}
