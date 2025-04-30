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

namespace Pimcore\Bundle\GoogleMarketingBundle\SiteId;

use Pimcore\Http\Request\Resolver\SiteResolver;
use Pimcore\Model\Site;
use Symfony\Component\HttpFoundation\Request;

class SiteIdProvider
{
    private SiteResolver $siteResolver;

    public function __construct(SiteResolver $siteResolver)
    {
        $this->siteResolver = $siteResolver;
    }

    /**
     * Resolve the site identifier for the given request
     *
     *
     */
    public function getForRequest(?Request $request = null): SiteId
    {
        if ($this->siteResolver->isSiteRequest($request)) {
            $site = $this->siteResolver->getSite($request);
            if (!$site) {
                throw new \RuntimeException('Failed to fetch site for site request');
            }

            return SiteId::forSite($site);
        }

        return SiteId::forMainDomain();
    }

    /**
     * Get a site id for a config key
     *
     *
     */
    public function getSiteId(string $configKey): SiteId
    {
        foreach ($this->getSiteIds() as $siteId) {
            if ($siteId->getConfigKey() === $configKey) {
                return $siteId;
            }
        }

        throw new \InvalidArgumentException(sprintf('Site config for key "%s" was not found', $configKey));
    }

    /**
     * Get all available site ids
     *
     *
     * @return SiteId[]
     */
    public function getSiteIds(bool $includeMainDomain = true): array
    {
        /** @var Site\Listing|Site\Listing\Dao $sites */
        $sites = new Site\Listing();

        $ids = [];

        if ($includeMainDomain) {
            $ids[] = SiteId::forMainDomain();
        }

        foreach ($sites->load() as $site) {
            $ids[] = SiteId::forSite($site);
        }

        return $ids;
    }
}
