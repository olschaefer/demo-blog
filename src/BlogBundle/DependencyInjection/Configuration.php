<?php


namespace BlogBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('blog');

        $rootNode->children()
            ->arrayNode('public')
                ->addDefaultsIfNotSet()
                ->children()
                    ->integerNode('posts_per_page')->defaultValue(2)->end()
                ->end()
            ->end()
            ->arrayNode('admin')
                ->addDefaultsIfNotSet()
                ->children()
                    ->integerNode('posts_per_page')->defaultValue(10)->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}