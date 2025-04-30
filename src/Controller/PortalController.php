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

namespace Pimcore\Bundle\GoogleMarketingBundle\Controller;

use Pimcore\Bundle\GoogleMarketingBundle\Config\SiteConfigProvider;
use Pimcore\Controller\Traits\JsonHelperTrait;
use Pimcore\Controller\UserAwareController;
use Pimcore\Model\Site;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @internal
 */
#[Route('/portal')]
class PortalController extends UserAwareController
{
    use JsonHelperTrait;

    #[Route(
        '/portlet-analytics-sites',
        name: 'pimcore_bundle_googlemarketing_portal_portletanalyticssites',
        methods: ['GET']
    )]
    public function portletAnalyticsSitesAction(
        TranslatorInterface $translator,
        SiteConfigProvider $siteConfigProvider
    ): JsonResponse {
        $sites = new Site\Listing();
        $data = [
            [
                'id' => 0,
                'site' => $translator->trans('main_site', [], 'admin'),
            ],
        ];

        foreach ($sites->load() as $site) {
            if ($siteConfigProvider->isSiteReportingConfigured($site)) {
                $data[] = [
                    'id' => $site->getId(),
                    'site' => $site->getMainDomain(),
                ];
            }
        }

        return $this->jsonResponse(['data' => $data]);
    }
}
