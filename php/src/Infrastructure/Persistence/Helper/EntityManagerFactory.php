<?php
namespace Sismoura\Agenda\Infrastructure\Persistence\Helper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;

class EntityManagerFactory
{
    public function getEntityManager(): EntityManagerInterface
    {
        $rootDir = __DIR__ . '/../../../..';
        $config = Setup::createXMLMetadataConfiguration(
            [$rootDir . '/src/Infrastructure/Persistence/Entitys'],
            true
        );
        
        $connection = [
            'driver' => 'pdo_sqlite',
            'path' => $rootDir . '/db/database.sqlite'
        ];
        return EntityManager::create($connection, $config);
    }
}