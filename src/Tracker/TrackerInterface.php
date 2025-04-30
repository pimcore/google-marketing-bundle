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

namespace Pimcore\Bundle\GoogleMarketingBundle\Tracker;

use Pimcore\Bundle\GoogleMarketingBundle\SiteId\SiteId;

interface TrackerInterface
{
    /**
     * Generates code for a specific site. If no site is passed the current site will be
     * automatically resolved.
     *
     *
     * @return null|string Null if no tracking is configured
     */
    public function generateCode(?SiteId $siteId = null): ?string;

    /**
     * Adds additional code to the tracker. Code can either be added to all trackers
     * or be restricted to a specific site.
     *
     * @param string $code        The code to add
     * @param string|null $block  The block where to add the code (will use default block if none given)
     * @param bool $prepend       Whether to prepend the code to the code block
     * @param SiteId|null $siteId Restrict code to a specific site
     */
    public function addCodePart(string $code, ?string $block = null, bool $prepend = false, ?SiteId $siteId = null): void;
}
