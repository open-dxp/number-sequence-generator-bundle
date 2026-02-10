<?php

/**
 * OpenDXP
 *
 * This source file is licensed under the GNU General Public License version 3 (GPLv3).
 *
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (https://pimcore.com)
 * @copyright  Modification Copyright (c) OpenDXP (https://www.opendxp.io)
 * @license    https://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License version 3 (GPLv3)
 */

namespace OpenDxp\Bundle\NumberSequenceGeneratorBundle;

use OpenDxp\Bundle\NumberSequenceGeneratorBundle\Migrations\Version20221209110849;
use OpenDxp\Extension\Bundle\Installer\SettingsStoreAwareInstaller;

class Installer extends SettingsStoreAwareInstaller
{
    public function install(): void
    {
        $this->installDatabaseTable();
        parent::install();
    }

    public function uninstall(): void
    {
        //nothing to do due to potential data loss
        parent::uninstall();
    }

    public function installDatabaseTable(): void
    {
        $sqlPath = __DIR__ . '/Resources/install/';
        $sqlFileNames = ['install.sql'];
        $db = \OpenDxp\Db::get();

        foreach ($sqlFileNames as $fileName) {
            $statement = file_get_contents($sqlPath.$fileName);
            $db->executeQuery($statement);
        }
    }

    public function getLastMigrationVersionClassName(): ?string
    {
        return Version20221209110849::class;
    }
}
