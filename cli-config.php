<?php

require __DIR__.'/resources/config/dev.php';

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$config->setProxyDir(__DIR__ . '/cache/Proxies');
$config->setProxyNamespace($app['doctrine_orm.config']['doctrine_orm.proxies_namespace']);
$config->setMetadataDriverImpl($config->newDefaultAnnotationDriver($app['doctrine_orm.config']['doctrine_orm.entities_path']));

$em = \Doctrine\ORM\EntityManager::create($app['doctrine_orm.config']['doctrine_orm.connection_parameters'], $config);

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));
