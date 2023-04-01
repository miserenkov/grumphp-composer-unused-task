[![License](https://poser.pugx.org/miserenkov/grumphp-composer-unused-task/license)](https://packagist.org/packages/miserenkov/grumphp-composer-unused-task)
[![Latest Stable Version](https://poser.pugx.org/miserenkov/grumphp-composer-unused-task/v/stable)](https://packagist.org/packages/miserenkov/grumphp-composer-unused-task)
[![Total Downloads](https://poser.pugx.org/miserenkov/grumphp-composer-unused-task/downloads)](https://packagist.org/packages/miserenkov/grumphp-composer-unused-task)

# grumphp-composer-unused-task

Run Composer Unused via GrumPHP

### grumphp.yml:

````yml
parameters:
    tasks:
      composer_unused:
        configuration: composer-unused.php
        exclude_dirs: [ ]
        exclude_packages: [ 'icanhazstring/composer-unused' ]
    extensions:
      - \MiSerenkov\GrumPHP\ComposerUnusedTask\ExtensionLoader
````

### Composer

``composer require --dev miserenkov/grumphp-composer-unused-task``