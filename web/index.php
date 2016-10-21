<?php

use Silex\Application;
use Symart\IndexBundle\Controller\HomeController;
use Symart\IndexBundle\Fetcher\HttpFetcher;
use Symart\IndexBundle\Parser\TextilmarParser;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(
    new SilexGuzzle\GuzzleServiceProvider(),
    [
        'guzzle.base_uri' => "/",
        'guzzle.timeout' => 10,
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
    $resolver->registerParser(new \Symart\IndexBundle\Parser\MamaFabricsParser());
    $resolver->registerParser(new \Symart\IndexBundle\Parser\OtulaParser());
    $resolver->registerParser(new \Symart\IndexBundle\Parser\SprzedajemyTkaninyParser());
    $resolver->registerParser(new \Symart\IndexBundle\Parser\DrecottonParser());

    return $resolver;
};

$app['symart_index_repository_product'] = function ($app) {
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
    '/dresowka_textil',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        return $controller->products(
            [
                'http://sklep.textilmar.pl/dzianina-dresowa-wzor-c-433.html',
                'http://sklep.textilmar.pl/dzianina-dresowa-c-289.html',
            ]
        );
    }
);

$app->get(
    '/dresowka_pl',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        return $controller->products(
            [
                'http://dresowka.pl/modules/blocklayered/blocklayered-ajax.php?layered_quantity_1=1&layered_id_feature_107=107_15&id_category_layered=71&layered_price_slider=4_40&orderby=position&orderway=asc&n=250&p=1&_=' . date('U'),
            ]
        );
    }
);

$app->get(
    '/dresowka_mama',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        return $controller->products(
            [
                'http://www.mamafabrics.pl/pl/c/Dresowka-drukowana-petelka/15',
            ]
        );
    }
);

$app->get(
    '/minky',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        return $controller->products(
            [
                'http://sklep.textilmar.pl/minky-welur-c-382.html',
            ]
        );
    }
);

$app->get(
    '/bawelna',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        return $controller->products(
            [
                'http://sklep.textilmar.pl/plotna-bawelniane-wzor-c-392.html',
                'http://sklep.textilmar.pl/plotna-bawelniane-kolor-c-445.html',
            ]
        );
    }
);
$app->get(
    '/bawelna-sprzedajemy_tkaniny',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];
        $urls = [];
        for ($i = 1; $i <= 6; $i++) {
            $urls[] = 'http://www.sprzedajemytkaniny.pl/pl/c/Tkaniny-Bawelniane/18/' . $i;
        }
        return $controller->products($urls);
    }
);

$app->get(
    '/bawelna_premium-sprzedajemy_tkaniny',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];
        $urls = [];
        for ($i = 1; $i <= 5; $i++) {
            $urls[] = 'http://www.sprzedajemytkaniny.pl/pl/c/Tkaniny-bawelniane-Premium/39/' . $i;
        }
        return $controller->products($urls);
    }
);


$app->get(
    '/bawelna_premium-craftoholic',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        $urls = [];
        for ($i = 1; $i <= 42; $i++) {
            $urls[] = 'http://craftoholicshop.com/pl/c/Tkaniny/32/' . $i;
        }

        return $controller->products($urls);
    }
);
$app->get(
    '/tkaniny_drecotton_1',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        $urls = [];
        for ($i = 1; $i <= 57; $i++) {
            $urls[] = 'http://drecotton.pl/pl/tkaniny-17#/page-' . $i;
        }

        return $controller->products($urls);
    }
);
$app->get(
    '/tkaniny_drecotton_2',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        $urls = [];
        for ($i = 58; $i <= 114; $i++) {
            $urls[] = 'http://drecotton.pl/pl/tkaniny-17#/page-' . $i;
        }

        return $controller->products($urls);
    }
);

$app->get(
    '/bawelna-czarna-craftoholic',
    function (Application $app) : Response {
        /** @var HomeController $controller */
        $controller = $app['symart_index_welcome_controller'];

        $urls = [];
        for ($i = 1; $i <= 7; $i++) {
            $urls[] = 'http://craftoholicshop.com/pl/c/czarny/67/' . $i;
        }

        return $controller->products($urls);
    }
);

$app->get(
    '/',
    function (Application $app) : Response {
        $controller = $app['symart_index_welcome_controller'];
        $routes = [];

        foreach ($app['routes'] as $route) {
            /** @var Silex\Route $route */
            $routes[] = $route->getPath();
        }

        return $controller->welcome($routes);
    }
);

$app->run();
