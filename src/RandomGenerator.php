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

use Exception;
use OpenDxp\Db;
use Symfony\Component\Lock\LockFactory;

class RandomGenerator
{
    /**
     *  key for lock table
     */
    const LOCK_KEY = 'number_sequence_generator';

    /**
     * numeric code
     */
    const NUMERIC = 'numeric';

    /**
     * alphanumeric code
     */
    const ALPHANUMERIC = 'alphanumeric';

    /**
     * table name
     */
    const TABLE_NAME = 'bundle_number_sequence_generator_randomregister';

    public function __construct(private readonly LockFactory $lockFactory)
    {
    }

    public function generateCode(
        string $range,
        string $codeType = self::NUMERIC,
        ?int $length = null,
        string $characterSet = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ'
    ): bool|int|string {
        return match ($codeType) {
            self::NUMERIC => $this->generateNumericCode($range),
            self::ALPHANUMERIC => $this->generateAlphanumericCode($range, $length, $characterSet),
            default => throw new Exception("Code Type $codeType not supported."),
        };
    }

    private function generateNumericCode(string $range): int
    {
        $lock = $this->lockFactory->createLock(self::LOCK_KEY);
        $lock->acquire(true);
        $db = Db::get();
        $code = $db->fetchOne('SELECT `code` FROM '.self::TABLE_NAME.' WHERE `range` = ?', [$range]);

        if ($code) {
            $code++;
            $updateData = ['code' => $code];
            $criteriaData = ['range' => $range];

            // keep compatible with opendxp 1.0 // TODO: Remove if opendxp 1.0 support is dropped
            if (!class_exists('\OpenDxp\Db\Connection')) {
                $updateData = Db\Helper::quoteDataIdentifiers($db, $updateData);
                $criteriaData = Db\Helper::quoteDataIdentifiers($db, $criteriaData);
            }
            $db->update(self::TABLE_NAME, $updateData, $criteriaData);
        } else {
            $code = 1;
            // keep compatible with opendxp 1.0 // TODO: Remove if opendxp 1.0 support is dropped
            $insertData = ['code' => $code, 'range' => $range];
            if (!class_exists('\OpenDxp\Db\Connection')) {
                $insertData = Db\Helper::quoteDataIdentifiers($db, $insertData);
            }

            $db->insert(self::TABLE_NAME, $insertData);
        }
        $lock->release();

        return $code;
    }

    private function generateAlphanumericCode(string $range, ?int $length, string $characterSet): string
    {
        if ($length && $length > 50) {
            throw new Exception('maximum code length is 50');
        }

        $lock = $this->lockFactory->createLock(self::LOCK_KEY);
        $lock->acquire(true);
        $result = true;
        $db = Db::get();

        while ($result) {
            $code = substr(str_shuffle($characterSet), 0, $length);
            $result = $db->fetchOne(
                'SELECT * FROM '.self::TABLE_NAME.' WHERE `range` = ? AND `code` = ?',
                [$range, $code]
            );
        }

        // keep compatible with opendxp 1.0 // TODO: Remove if opendxp 1.0 support is dropped
        $insertData = ['code' => $code, 'range' => $range];
        if (!class_exists('\OpenDxp\Db\Connection')) {
            $insertData = Db\Helper::quoteDataIdentifiers($db, $insertData);
        }
        $db->insert(self::TABLE_NAME, $insertData);

        $lock->release();

        return $code;
    }

    public function resetCodeGenerator(string $range): void
    {
        $db = Db::get();
        $db->executeQuery('DELETE FROM '.self::TABLE_NAME.' WHERE `range` = ?', [$range]);
    }
}
