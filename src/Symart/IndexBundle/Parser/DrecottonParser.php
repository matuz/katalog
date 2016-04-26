<?php

namespace Symart\IndexBundle\Parser;

use pQuery;
use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;

class DrecottonParser implements ParserInterface
{
    /**
     * @param Page $page
     *
     * @return array|Product[]
     */
    public function parseIndexPage(Page $page)
    {
        $pageContent = pQuery::parseStr($page->getHtml());

        $divs = $pageContent->query('#product_list li');

        $result = [];
        /** @var pQuery\DomNode $div */
        foreach ($divs as $div) {
            $result[] = (new Product())
                ->setUrl($div->query('a.product_image')->attr('href'))
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
        return $page->getHost() === 'http://drecotton.pl';
    }
}