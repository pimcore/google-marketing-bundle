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

namespace Pimcore\Bundle\GoogleMarketingBundle\Code;

use Pimcore\Bundle\GoogleMarketingBundle\SiteId\SiteId;

/**
 * Collects additional code parts which should be added to specific blocks upon rendering. Code
 * parts can be added on a global level or restricted to a specific site.
 */
class CodeCollector
{
    const CONFIG_KEY_GLOBAL = '__global';

    const ACTION_PREPEND = 'prepend';

    const ACTION_APPEND = 'append';

    private string $defaultBlock;

    private array $validBlocks;

    private array $codeParts = [];

    private array $validActions = [
        self::ACTION_PREPEND,
        self::ACTION_APPEND,
    ];

    public function __construct(array $validBlocks, string $defaultBlock)
    {
        if (!in_array($defaultBlock, $validBlocks)) {
            throw new \LogicException(sprintf(
                'The default block "%s" must be a part of the valid blocks',
                $defaultBlock
            ));
        }

        $this->validBlocks = $validBlocks;
        $this->defaultBlock = $defaultBlock;
    }

    /**
     * Adds additional code to the tracker
     *
     * @param SiteId|null $siteId Restrict code part to a specific site
     */
    public function addCodePart(string $code, ?string $block = null, string $action = self::ACTION_APPEND, ?SiteId $siteId = null): void
    {
        if (!in_array($action, $this->validActions)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid action "%s". Valid actions are: %s',
                $action,
                implode(', ', $this->validActions)
            ));
        }

        $configKey = self::CONFIG_KEY_GLOBAL;
        if (null !== $siteId) {
            $configKey = $siteId->getConfigKey();
        }

        if (null === $block) {
            $block = $this->defaultBlock;
        }

        if (!in_array($block, $this->validBlocks)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid block "%s". Valid values are: %s',
                $block,
                implode(', ', $this->validBlocks)
            ));
        }

        if (!isset($this->codeParts[$configKey])) {
            $this->codeParts[$configKey] = [];
        }

        if (!isset($this->codeParts[$configKey][$block])) {
            $this->codeParts[$configKey][$block] = [];
        }

        if (!isset($this->codeParts[$configKey][$block][$action])) {
            $this->codeParts[$configKey][$block][$action] = [];
        }

        $this->codeParts[$configKey][$block][$action][] = $code;
    }

    /**
     * Adds registered parts to a code block
     *
     */
    public function enrichCodeBlock(SiteId $siteId, CodeBlock $codeBlock, string $block): void
    {
        // global parts not restricted to a config key
        $this->enrichBlock(self::CONFIG_KEY_GLOBAL, $codeBlock, $block);

        // config key specific parts
        $this->enrichBlock($siteId->getConfigKey(), $codeBlock, $block);
    }

    private function enrichBlock(string $configKey, CodeBlock $codeBlock, string $block): void
    {
        if (!isset($this->codeParts[$configKey])) {
            return;
        }

        $blockParts = $this->codeParts[$configKey][$block] ?? [];
        if (empty($blockParts)) {
            return;
        }

        foreach ([self::ACTION_PREPEND, self::ACTION_APPEND] as $position) {
            if (isset($blockParts[$position])) {
                if (self::ACTION_PREPEND === $position) {
                    $codeBlock->prepend($blockParts[$position]);
                } else {
                    $codeBlock->append($blockParts[$position]);
                }
            }
        }
    }
}
