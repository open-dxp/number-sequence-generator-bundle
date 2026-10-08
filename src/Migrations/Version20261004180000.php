<?php

declare(strict_types=1);

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
use OpenDxp\Bundle\NumberSequenceGeneratorBundle\OpenDxpNumberSequenceGeneratorBundle;
use OpenDxp\Bundle\NumberSequenceGeneratorBundle\RandomGenerator;
use Override;

final class Version20261004180000 extends AbstractMigration
{
    #[Override]
    public function getDescription(): string
    {
        return 'Marks an installation under the current bundle name instead of the name before OpenDXP.';
    }

    #[Override]
    public function up(Schema $schema): void
    {
        $this->addSql("DELETE FROM settings_store WHERE id = 'BUNDLE_INSTALLED__OpenDxp\\\\NumberSequenceGeneratorBundle\\\\NumberSequenceGeneratorBundle' AND scope = 'opendxp'");

        if (!$schema->hasTable('bundle_number_sequence_generator_register') || !$schema->hasTable(RandomGenerator::TABLE_NAME)) {
            return;
        }

        $this->addSql(
            'INSERT INTO settings_store (id, scope, type, data) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE data = VALUES(data);',
            ['BUNDLE_INSTALLED__' . OpenDxpNumberSequenceGeneratorBundle::class, 'opendxp', 'bool', '1'],
        );
    }

    #[Override]
    public function down(Schema $schema): void
    {
    }
}
