# Number Sequence Generator Bundle

***

## Disclaimer

> OpenDXP is a community-driven fork based on the Pimcore® Community Edition (GPLv3).  
> OpenDXP is independent and maintained by its community and contributors.
> It is not affiliated with, endorsed by, or sponsored by Pimcore GmbH.   
> Original credits: [Pimcore GmbH](https://www.pimcore.com)

**OpenDXP Number Sequence Generator Bundle is based on the Pimcore® Community Edition and remains licensed under GPLv3.**

***

## Continues numbers

Generates continous numbers for example for order numbers or customer numbers.

```php
public function exampleAction(OpenDxp\Bundle\NumberSequenceGeneratorBundle\Generator $generator) {
    /*
    * Generates the next order number (increments current order number by 1)
    * If no order number was generated before it will start with 10000
    */
    $next = $generator->getNext('ordernumber', 10000);

    /*
    * Receive the current order number without incrementing the counter.
    */
    $current = $generator->getCurrent('ordernumber');

    /*
    * Sets the order number to 35017 in the database.
    */
    $generator->setCurrent('ordernumber', 35017);
}
```
## Random numbers (either numeric or alphanumeric)

Generates unique random numbers.

```php
public function __construct(Generator $generator)
{
    $this->generator = $generator;
}

public function generateCode()
{
    $code = $this->generator->generateCode("vouchercode", \OpenDxp\Bundle\NumberSequenceGeneratorBundle\RandomGenerator::ALPHANUMERIC, 32);
}
```


## Documentation Overview

- [Installation](./doc/01_Installation.md)

***

## Upstream Origin & Version Transparency
This project is a fork of the [Pimcore number-sequence-generator (04fc42e / v2.0.1)](https://github.com/pimcore/number-sequence-generator/tree/04fc42e91eeadc54e9f30b5793c4faed7a409373), which is © Pimcore GmbH and licensed under GPLv3.

## License
Licensed under the GNU General Public License v3.0 (GPLv3). For details, please see [LICENSE.md](LICENSE.md).

## Copyright
© Pimcore GmbH  
© 2026 OpenDXP Contributors — GPLv3

## Trademarks
Pimcore® is a registered [trademark](https://www.trademarkelite.com/europe/trademark/trademark-detail/009309841/PIMCORE) of Pimcore GmbH.
Any use of the Pimcore® mark in this repository is purely descriptive to identify the original upstream project.

***

## Contact
For inquiries, suggestions, or contributions, feel free to reach us at contact@opendxp.ch.

## About
OpenDXP is a community-driven project initiated by [DACHCOM.DIGITAL](https://www.dachcom.com/de-ch) (Rheineck, Switzerland) and maintained by its community and contributors.
OpenDXP is independent and not affiliated with Pimcore GmbH.

The project’s purpose is to preserve and maintain a GPLv3‑licensed codebase for community use.

It is **not positioned as a competitor** to products or services of Pimcore GmbH and does **not** purport to replace or supersede any Pimcore offering.   
