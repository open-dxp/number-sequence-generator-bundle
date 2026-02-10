<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
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
