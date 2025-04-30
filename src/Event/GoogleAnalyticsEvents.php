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

namespace Pimcore\Bundle\GoogleMarketingBundle\Event;

final class GoogleAnalyticsEvents
{
    /**
     * Triggered before a tracking code block is rendered. Can be used to add additional code
     * snippets to the tracking block.
     *
     * @Event("Pimcore\Bundle\GoogleMarketingBundle\Model\Event\TrackingDataEvent")
     *
     * @var string
     */
    const CODE_TRACKING_DATA = 'pimcore.tracking.google.code.tracking_data';
}
