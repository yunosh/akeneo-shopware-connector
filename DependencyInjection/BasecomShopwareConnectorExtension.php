<?php

namespace Basecom\Bundle\ShopwareConnectorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class BasecomShopwareConnectorExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        // ToDo: Kann raus, oder?
        //$loader->load('messages.en.yml');
        // ToDo: Bitte noch alphabetisch ordnen, sieht dann strukturierter aus
        $loader->load('readers.yml');
        $loader->load('processors.yml');
        $loader->load('writers.yml');
        $loader->load('entities.yml');
        $loader->load('serializers.yml');
        $loader->load('models.yml');
        $loader->load('steps.yml');
        $loader->load('controllers.yml');
    }
}