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

namespace Pimcore\Bundle\GoogleMarketingBundle;

use Pimcore\Extension\Bundle\Installer\SettingsStoreAwareInstaller;

class Installer extends SettingsStoreAwareInstaller
{
    protected const USER_PERMISSIONS_CATEGORY = 'Pimcore Google Marketing Bundle';

    const USER_PERMISSIONS = [
        'google_marketing',
    ];

    protected function addPermissions(): void
    {
        $db = \Pimcore\Db::get();

        foreach (self::USER_PERMISSIONS as $permission) {
            $db->insert('users_permission_definitions', [
                $db->quoteIdentifier('key') => $permission,
                $db->quoteIdentifier('category') => self::USER_PERMISSIONS_CATEGORY,
            ]);
        }
    }

    protected function removePermissions(): void
    {
        $db = \Pimcore\Db::get();

        foreach (self::USER_PERMISSIONS as $permission) {
            $db->delete('users_permission_definitions', [
                $db->quoteIdentifier('key') => $permission,
            ]);
        }
    }

    public function install(): void
    {
        $this->addPermissions();
        $this->installDependentBundles();
        parent::install();
    }

    public function installDependentBundles(): void
    {
        //Install CustomReportsBundle
        $customReportsInstaller = \Pimcore::getContainer()->get(\Pimcore\Bundle\CustomReportsBundle\Installer::class);
        if (!$customReportsInstaller->isInstalled()) {
            $customReportsInstaller->install();
        }
    }

    public function uninstall(): void
    {
        $this->removePermissions();
        parent::uninstall();
    }
}
