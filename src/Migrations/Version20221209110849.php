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

namespace OpenDxp\Bundle\NumberSequenceGeneratorBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use OpenDxp\Bundle\NumberSequenceGeneratorBundle\RandomGenerator;
use OpenDxp\Model\Tool\SettingsStore;

/**
 * Checking if tables already exist
 */
class Version20221209110849 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $result1 = \OpenDxp\Db::get()->fetchOne('SHOW TABLES LIKE "bundle_number_sequence_generator_register"');
        $result2 = \OpenDxp\Db::get()->fetchOne('SHOW TABLES LIKE "' . RandomGenerator::TABLE_NAME . '"');

        $installed = !empty($result1) && !empty($result2);

        if ($installed) {
            SettingsStore::set('BUNDLE_INSTALLED__OpenDxp\\NumberSequenceGeneratorBundle\\NumberSequenceGeneratorBundle', $installed, 'bool', 'opendxp');
        }
    }

    #[\Override]
    public function down(Schema $schema): void
    {
    }
}
