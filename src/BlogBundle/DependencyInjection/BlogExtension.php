<?php

namespace BlogBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class BlogExtension extends ConfigurableExtension
{
    /**
     * @param array $mergedConfig
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');

        /**
         * Setting up controllers for post list rendering in public & admin areas
         */
        $services = [
            'blog.controller.list' => [
                $mergedConfig['public']['posts_per_page'],
                'blog_list_page',
                'blog_post_page',
                'slug',
            ],
            'blog.controller.list.admin' => [
                $mergedConfig['admin']['posts_per_page'],
                'blog_admin_list_page',
                'blog_admin_edit',
                'id',
            ],
        ];

        foreach ($services as $serviceId => $arguments) {
            $def = $container->getDefinition($serviceId);
            foreach ($arguments as $index => $argument) {
                $def->replaceArgument($index, $argument);
            }
        }
    }
}