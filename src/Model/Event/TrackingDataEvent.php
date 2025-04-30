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

namespace Pimcore\Bundle\GoogleMarketingBundle\Model\Event;

use Pimcore\Bundle\GoogleMarketingBundle\Code\CodeBlock;
use Pimcore\Bundle\GoogleMarketingBundle\Config\Config;
use Pimcore\Bundle\GoogleMarketingBundle\SiteId\SiteId;
use Symfony\Contracts\EventDispatcher\Event;

class TrackingDataEvent extends Event
{
    private Config $config;

    private SiteId $siteId;

    /**
     * @var array<string, mixed>
     */
    private array $data;

    /**
     * @var CodeBlock[]
     */
    private array $blocks;

    private string $template;

    /**
     * @param array<string, mixed> $data
     * @param CodeBlock[] $blocks
     */
    public function __construct(
        Config $config,
        SiteId $siteId,
        array $data,
        array $blocks,
        string $template
    ) {
        $this->config = $config;
        $this->siteId = $siteId;
        $this->data = $data;
        $this->blocks = $blocks;
        $this->template = $template;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getSiteId(): SiteId
    {
        return $this->siteId;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return CodeBlock[]
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function getBlock(string $block): CodeBlock
    {
        if (!isset($this->blocks[$block])) {
            throw new \InvalidArgumentException(sprintf('Invalid block "%s"', $block));
        }

        return $this->blocks[$block];
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }
}
