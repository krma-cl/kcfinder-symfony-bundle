<?php

declare(strict_types=1);

namespace Krma\KCFinder\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('kcfinder');
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('filesystem_service')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('url_prefix')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('security_attribute')->defaultValue('KCFINDER_SELECT')->cannotBeEmpty()->end()
                ->scalarNode('browser_url')->defaultValue('/vendor/kcfinder/browse.php')->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}
