<?php
// this file is for vendor/doctrine/bin/console and its testing purposes
use Doctrine\ORM\Tools\Console\ConsoleRunner;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = [__DIR__ . '/../DrdPlus'];
$config = Setup::createAnnotationMetadataConfiguration($paths, true /* dev mode */);
$cache = new \Doctrine\Common\Cache\ArrayCache();
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);
$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
    new \Doctrine\Common\Annotations\AnnotationReader(),
    $paths
);
$config->setMetadataDriverImpl($driver);

$entityManager = EntityManager::create(
    [
        'driver' => 'pdo_sqlite',
        'path' => ':memory:',
    ],
    $config
);

\DrdPlus\Exceptionalities\EnumTypes\ExceptionalitiesEnumRegistrar::registerAll();

return ConsoleRunner::createHelperSet($entityManager);
