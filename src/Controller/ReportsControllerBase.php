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

use Pimcore\Config;
use Pimcore\Controller\UserAwareController;

/**
 * @internal
 */
abstract class ReportsControllerBase extends UserAwareController
{
    public function getConfig(): array
    {
        return Config::getReportConfig();
    }
}
