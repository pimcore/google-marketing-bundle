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

namespace Pimcore\Bundle\GoogleMarketingBundle\Config;

class ConfigProvider
{
    private ?Config $config = null;

    /**
     * @var array<string, mixed>|null
     */
    private ?array $configObject = null;

    /**
     * @param array<string, mixed>|null $configObject
     */
    public function __construct(?array $configObject = null)
    {
        $this->configObject = $configObject;
    }

    public function getConfig(): Config
    {
        if (null === $this->config) {
            $this->config = new Config($this->getConfigObject());
        }

        return $this->config;
    }

    /**
     * @return array<string, mixed>
     */
    private function getConfigObject(): array
    {
        if (null === $this->configObject) {
            $this->configObject = $this->loadDefaultConfigObject();
        }

        return $this->configObject;
    }

    /**
     * @return array<string, mixed>
     */
    protected function loadDefaultConfigObject(): array
    {
        $reportConfig = \Pimcore\Config::getReportConfig();

        return $reportConfig['analytics'] ?? [];
    }
}
