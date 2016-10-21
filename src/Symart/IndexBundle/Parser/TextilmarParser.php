<?php

namespace Symart\IndexBundle\Parser;

use pQuery;
use Symart\IndexBundle\DTO\Page;
use Symart\IndexBundle\Entity\Product;

class TextilmarParser implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parseIndexPage(Page $page) : array
    {
        $pageContent = pQuery::parseStr($page->getHtml());

        $divs = $pageContent->query('#lista_produktow .produkt_div');

        $result = [];
        /** @var pQuery\DomNode $div */
        foreach ($divs as $div) {
            $result[] = (new Product())
                ->setUrl($div->query('a.prod_name_2')->attr('href'))
                ->setImage($page->getHost() . '/' . $div->query('img')->attr('src'));
        }

        return $result;
    }

    /**
     * @param Page $page
     *
     * @return bool
     */
    public function support(Page $page) : bool
    {
        return $page->getHost() === 'http://sklep.textilmar.pl';
    }
}
