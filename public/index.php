<?php

declare(strict_types = 1);

use App\Config;
use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Extra\Intl\IntlExtension;

use function DI\create;

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../configs/path_constants.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$container = new Container();

AppFactory::setContainer($container);

$app = AppFactory::create();

$router($app);

$app->add(TwigMiddleware::create($app, $container->get(Twig::class)));

$app->run();
