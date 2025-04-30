<?php

/**
 * This source file is available under the terms of the
 * Pimcore Open Core License (POCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (https://www.pimcore.com)
 *  @license    Pimcore Open Core License (POCL)
 */

namespace Pimcore\Bundle\GoogleMarketingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('pimcore_google_marketing');

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();
        $rootNode->addDefaultsIfNotSet();

        $rootNode
            ->children()
                ->scalarNode('client_id')
                    ->info('This is required for the Google API integrations. Only use a `Service Account´ from the Google Cloud Console.')
                    ->defaultNull()
                ->end()
                ->scalarNode('email')
                    ->info('Email address of the Google service account')
                    ->defaultNull()
                ->end()
                ->scalarNode('simple_api_key')
                    ->info('Server API key')
                    ->defaultNull()
                ->end()
                ->scalarNode('browser_api_key')
                    ->info('Browser API key')
                    ->defaultNull()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
