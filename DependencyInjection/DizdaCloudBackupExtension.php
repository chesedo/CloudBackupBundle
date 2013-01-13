<?php

namespace Dizda\CloudBackupBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DizdaCloudBackupExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');


        $container->setParameter('dizda_cloud_backup.cloud_storages.dropbox.user',      $config['cloud_storages']['dropbox']['user']);
        $container->setParameter('dizda_cloud_backup.cloud_storages.dropbox.password',  $config['cloud_storages']['dropbox']['password']);


        if(isset($config['databases']['mongodb']))
        {
            $container->setParameter('dizda_cloud_backup.databases.mongodb.active',         true);
            $container->setParameter('dizda_cloud_backup.databases.mongodb.all_databases',  $config['databases']['mongodb']['all_databases']);
            $container->setParameter('dizda_cloud_backup.databases.mongodb.database',       $config['databases']['mongodb']['database']);
            $container->setParameter('dizda_cloud_backup.databases.mongodb.db_user',        $config['databases']['mongodb']['db_user']);
            $container->setParameter('dizda_cloud_backup.databases.mongodb.db_password',    $config['databases']['mongodb']['db_password']);
        }else{
            $container->setParameter('dizda_cloud_backup.databases.mongodb.active',         false);
        }

        if(isset($config['databases']['mysql']))
        {
            $container->setParameter('dizda_cloud_backup.databases.mysql.active',         true);
            $container->setParameter('dizda_cloud_backup.databases.mysql.all_databases',  $config['databases']['mysql']['all_databases']);
            $container->setParameter('dizda_cloud_backup.databases.mysql.database',       $config['databases']['mysql']['database']);
            $container->setParameter('dizda_cloud_backup.databases.mysql.host',           $config['databases']['mysql']['host']);
            $container->setParameter('dizda_cloud_backup.databases.mysql.port',           $config['databases']['mysql']['port']);
            $container->setParameter('dizda_cloud_backup.databases.mysql.db_user',        $config['databases']['mysql']['db_user']);
            $container->setParameter('dizda_cloud_backup.databases.mysql.db_password',    $config['databases']['mysql']['db_password']);
        }else{
            $container->setParameter('dizda_cloud_backup.databases.mysql.active',         false);
        }
    }
}
