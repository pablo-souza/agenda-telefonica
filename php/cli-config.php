<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Sismoura\Agenda\Infrastructure\Persistence\Helper\EntityManagerFactory;

require_once __DIR__.'/vendor/autoload.php';

$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);