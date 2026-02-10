# Installation of the Number Sequence Generator Bundle

## Bundle Installation

To install the Number Sequence Generator Bundle, follow the three steps below:

1) Install the required dependencies:

```bash
composer require open-dxp/number-sequence-generator-bundle
```

2) Make sure the bundle is enabled in the `config/bundles.php` file. The following lines should be added:

```php
return [
    // ...
    OpenDxp\Bundle\NumberSequenceGeneratorBundle\OpenDxpNumberSequenceGeneratorBundle::class => ['all' => true],
    // ...
];  
```

3) Install the bundle:

```bash
bin/console opendxp:bundle:install OpenDxpNumberSequenceGeneratorBundle
```
