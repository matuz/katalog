<?php

use Symart\IndexBundle\Controller\HomeController;
use Symart\IndexBundle\Fetcher\HttpFetcher;
use Symart\IndexBundle\Parser\TextilmarParser;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(
    new SilexGuzzle\GuzzleServiceProvider(),
    [
        'guzzle.base_uri' => "/",
        'guzzle.timeout' => 3.14,
    ]
);

$app->register(
    new Silex\Provider\DoctrineServiceProvider(),
    [
        'dbs.options' => [
            'default' => [
                'driver' => 'pdo_mysql',
                'host' => 'localhost',
                'dbname' => 'katalog',
                'user' => 'root',
                'password' => 'root',
                'charset' => 'utf8mb4',
            ]
        ]
    ]
);

$app->register(new \Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/views',
]);

$app['symart_index_fetcher'] = function ($app) {
    return new HttpFetcher($app['guzzle']);
};

$app['symart_index_parser_resolver'] = function () {
    $resolver = new \Symart\IndexBundle\Parser\ParserResolver();
    $resolver->registerParser(new TextilmarParser());
    $resolver->registerParser(new \Symart\IndexBundle\Parser\DresowkaParser());
    $resolver->registerParser(new \Symart\IndexBundle\Parser\CraftoholicParser());

    return $resolver;
};

$app['symart_index_repository_product'] = function($app) {
    return new \Symart\IndexBundle\Repository\ProductRepository($app['db']);
};

$app['symart_index_welcome_controller'] = function ($app) {
    return new HomeController(
        $app['symart_index_fetcher'],
        $app['symart_index_parser_resolver'],
        $app['symart_index_repository_product']
    );
};

$app->get(
    '/dresowka',
    function (\Silex\Application $app) {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        return $controller->welcome(
            [
                'http://sklep.textilmar.pl/dzianina-dresowa-wzor-c-433.html',
                'http://sklep.textilmar.pl/dzianina-dresowa-c-289.html',
                'http://dresowka.pl/pl/c/Dzianiny-we-wzory/279',
                'http://dresowka.pl/pl/c/Dzianiny-we-wzory/279/2',
                'http://dresowka.pl/pl/c/Dzianiny-we-wzory/279/3',
            ]
        );
    }
);

$app->get(
    '/minky',
    function (\Silex\Application $app) {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        return $controller->welcome(
            [
                'http://sklep.textilmar.pl/minky-welur-c-382.html',
            ]
        );
    }
);

$app->get(
    '/bawelna',
    function (\Silex\Application $app) {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        $urls = [];
        for ($i = 1; $i <= 42; $i ++) {
            $urls[] = 'http://craftoholicshop.com/pl/c/Tkaniny/32/' . $i;
        }

        return $controller->welcome(
            [
                'http://sklep.textilmar.pl/plotna-bawelniane-wzor-c-392.html',
                'http://sklep.textilmar.pl/plotna-bawelniane-kolor-c-445.html',
            ]
        );
    }
);

$app->get(
    '/bawelna_premium',
    function (\Silex\Application $app) {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        $urls = [];
        for ($i = 1; $i <= 42; $i ++) {
            $urls[] = 'http://craftoholicshop.com/pl/c/Tkaniny/32/' . $i;
        }

        return $controller->welcome($urls);
    }
);

$app->run();
