<?php

namespace Hyperreal\AcaciaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('acacia');

        $rootNode
            ->children()
                ->arrayNode('listing')
                    ->children()
                        ->integerNode('per_page')->min(1)->max(200)->defaultValue(30)->end()
                    ->end()
                ->end()
                ->scalarNode('route_map_file')->isRequired()->cannotBeEmpty()
                    ->validate()
                        ->ifTrue(
                            function ($value) {
                                return !file_exists(__DIR__ . '/../../../../' . $value);
                            }
                        )
                        ->thenInvalid('Route map should exist!')
                        ->ifTrue(
                            function ($value) {
                                return 'yml' !== strtolower(pathinfo($value, PATHINFO_EXTENSION));
                            }
                        )
                        ->thenInvalid('Only YML files are supported in acacia.route_map_file option')
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
