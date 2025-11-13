<?php

declare(strict_types=1);

/**
 * This source file is available under the terms of the
 * Pimcore Open Core License (POCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (https://www.pimcore.com)
 *  @license    Pimcore Open Core License (POCL)
 */

namespace Pimcore\Bundle\GoogleMarketingBundle;

use Pimcore\Bundle\CustomReportsBundle\PimcoreCustomReportsBundle;
use Pimcore\Bundle\GoogleMarketingBundle\DependencyInjection\PimcoreGoogleMarketingExtension;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Installer;
use Pimcore\Extension\Bundle\PimcoreBundleAdminClassicInterface;
use Pimcore\Extension\Bundle\Traits\BundleAdminClassicTrait;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Pimcore\HttpKernel\Bundle\DependentBundleInterface;
use Pimcore\HttpKernel\BundleCollection\BundleCollection;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * @deprecated version 2.1
 */
class PimcoreGoogleMarketingBundle extends AbstractPimcoreBundle implements DependentBundleInterface, PimcoreBundleAdminClassicInterface
{
    use BundleAdminClassicTrait;
    use PackageVersionTrait;

    public function __construct()
    {
        trigger_deprecation(
            'pimcore/google-marketing-bundle',
            '2.1',
            'The GoogleMarketingBundle is deprecated and will be discontinued with Pimcore Studio.'
        );
    }

    public function getContainerExtension(): ExtensionInterface
    {
        return new PimcoreGoogleMarketingExtension();
    }

    public function getComposerPackageName(): string
    {
        return 'pimcore/google-marketing-bundle';
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getCssPaths(): array
    {
        return [
            '/bundles/pimcoregooglemarketing/css/googlemarketing.css',
        ];
    }

    public function getJsPaths(): array
    {
        return [
            '/bundles/pimcoregooglemarketing/js/startup.js',
            '/bundles/pimcoregooglemarketing/js/settings.js',
            '/bundles/pimcoregooglemarketing/js/report/analytics/elementexplorer.js',
            '/bundles/pimcoregooglemarketing/js/report/analytics/elementoverview.js',
            '/bundles/pimcoregooglemarketing/js/report/analytics/settings.js',
            '/bundles/pimcoregooglemarketing/js/report/custom/definitions/analytics.js',
            '/bundles/pimcoregooglemarketing/js/report/tagmanager/settings.js',
            '/bundles/pimcoregooglemarketing/js/report/googleSearchConsole/settings.js',
            '/bundles/pimcoregooglemarketing/js/layout/portlets/analytics.js',
        ];
    }

    public function getInstaller(): ?Installer\InstallerInterface
    {
        /** @var \Pimcore\Bundle\GoogleMarketingBundle\Installer $installer */
        $installer = $this->container->get(\Pimcore\Bundle\GoogleMarketingBundle\Installer::class);

        return $installer;
    }

    public static function registerDependentBundles(BundleCollection $collection): void
    {
        $collection->addBundle(PimcoreCustomReportsBundle::class, 20);
    }
}
