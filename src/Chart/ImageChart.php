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

namespace Pimcore\Bundle\GoogleMarketingBundle\Chart;

/**
 * @internal
 */
final class ImageChart
{
    public static string $serviceUrl = 'https://chart.googleapis.com/chart';

    public static function lineSmall(array $data, string $parameters = ''): string
    {
        return self::$serviceUrl . '?cht=lc&chs=150x40&chd=t:' . implode(',', $data) . '&chds=' . min($data) . ',' . max($data) . '&' . $parameters;
    }
}
