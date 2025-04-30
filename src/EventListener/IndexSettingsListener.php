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

namespace Pimcore\Bundle\GoogleMarketingBundle\EventListener;

use Pimcore\Bundle\AdminBundle\Event\IndexActionSettingsEvent;
use Pimcore\Bundle\GoogleMarketingBundle\Config\SiteConfigProvider;

class IndexSettingsListener
{
    public function __construct(protected SiteConfigProvider $siteConfigProvider)
    {
    }

    public function indexSettings(IndexActionSettingsEvent $settingsEvent): void
    {
        $settingsEvent->addSetting('google_analytics_enabled', $this->siteConfigProvider->isSiteReportingConfigured());
    }
}
