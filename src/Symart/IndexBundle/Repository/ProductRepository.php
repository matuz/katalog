<?php

namespace Symart\IndexBundle\Repository;

use Doctrine\DBAL\Connection;
use Symart\IndexBundle\Entity\Category;
use Symart\IndexBundle\Entity\Product;

class ProductRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Product $product
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function ensureProduct(Product $product)
    {
        $statement = $this->connection->query("SELECT id FROM product WHERE url = '{$product->getUrl()}' ");

        $id = $statement->fetchColumn();

        if ($id === false) {
            $this->connection->insert('product', ['url' => $product->getUrl(), 'image' => $product->getImage()]);
            $id = $this->connection->lastInsertId('product');
        }

        $product->setId($id);
    }

    /**
     * @param Category $category
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function ensureCategory(Category $category)
    {
        $statement = $this->connection->query("SELECT id FROM category WHERE url = '{$category->getUrl()}' ");

        $id = $statement->fetchColumn();

        if ($id === false) {
            $this->connection->insert('category', ['url' => $category->getUrl()]);
            $id = $this->connection->lastInsertId('category');
        }

        $category->setId($id);
    }

    /**
     * @param string $uri
     *
     * @return null|Category
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getCategory($uri)
    {
        $statement = $this->connection->query("SELECT * FROM category WHERE url = '{$uri}' ");
        $result = $statement->fetch();

        if (count($result) > 0) {
            $category = new Category();
            $category->setId($result[0]['id'])->setUrl($result[0]['url']);
        } else {
            return null;
        }

        return $category;
    }

    public function clearProductAssigments(Category $category)
    {
        $this->connection->executeQuery("DELETE FROM product_to_category WHERE category_id = {$category->getId()}");
    }
    
    /**
     * @param Category $category
     * @param Product $product
     */
    public function assignToCategory(Category $category, Product $product)
    {
        $this->connection->insert('product_to_category', ['product_id' => $product->getId(), 'category_id' => $category->getId()]);
    }
}
