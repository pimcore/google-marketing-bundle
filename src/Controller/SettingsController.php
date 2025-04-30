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

use Exception;
use Pimcore\Config\ReportConfigWriter;
use Pimcore\Controller\Traits\JsonHelperTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @internal
 */
#[Route('/settings')]
class SettingsController extends ReportsControllerBase
{
    use JsonHelperTrait;

    #[Route('/get', name: 'pimcore_bundle_googlemarketing_settings_get', methods: ['GET'])]
    public function getAction(Request $request): JsonResponse
    {
        $this->checkPermission('google_marketing');
        $config = $this->getConfig();

        $response = [
            'values' => $config,
            'config' => [],
        ];

        return $this->jsonResponse($response);
    }

    #[Route('/save', name: 'pimcore_bundle_googlemarketing_settings_save', methods: ['PUT'])]
    public function saveAction(Request $request, ReportConfigWriter $configWriter): JsonResponse
    {
        $this->checkPermission('google_marketing');

        $values = $this->decodeJson($request->get('data'));
        if (!is_array($values)) {
            $values = [];
        }

        try {
            $configWriter->write($values);
        } catch (Exception $e) {
            $result = [
                'success' => false,
                'errors' => [$e->getMessage()],
            ];

            return $this->jsonResponse($result);
        }

        return $this->jsonResponse(['success' => true]);
    }
}
