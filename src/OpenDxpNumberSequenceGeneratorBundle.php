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

use OpenDxp\Bundle\NumberSequenceGeneratorBundle\DependencyInjection\OpenDxpNumberSequenceGeneratorExtension;
use OpenDxp\Extension\Bundle\AbstractOpenDxpBundle;
use OpenDxp\Extension\Bundle\Traits\PackageVersionTrait;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class OpenDxpNumberSequenceGeneratorBundle extends AbstractOpenDxpBundle
{
    use PackageVersionTrait;

    public function getContainerExtension(): ExtensionInterface
    {
        if ($this->extension === null) {
            $this->extension = new OpenDxpNumberSequenceGeneratorExtension();
        }

        return $this->extension;
    }

    protected function getComposerPackageName(): string
    {
        return 'open-dxp/number-sequence-generator-bundle';
    }

    public function getInstaller(): Installer
    {
        return $this->container->get(Installer::class);
    }
}
