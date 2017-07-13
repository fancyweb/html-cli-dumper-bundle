HtmlCliDumperBundle
===================

This bundle let you view your cli dumps as HTML dumps.

For every cli dump, it creates an HTML file containing the HTML version of the dump and display the link to this file in the console.

This is especially useful when you dump a large object in a `Command`, and you want to check a particular property that gets lost in thousand of lines. 

Installation
------------

### Download the bundle
```bash
composer require fancyweb/html-cli-dumper-bundle --dev
```

### Register the bundle
```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        // ...
        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            // ...
            if ('dev' === $this->getEnvironment()) {
                // ...
                $bundles[] = new Fancyweb\HtmlCliDumperBundle\HtmlCliDumperBundle();
            }
        }
    }
    // ...
}
```

### Requirement
This bundle only works when the Symfony `DebugBundle` is also registered.


Configuration
-------------

### Default
```yaml
html_cli_dumper:
    enabled:              true
    save_directory_path:  '%kernel.root_dir%/../web/_html_cli_dumper_data'
    view_base_url:        '%router.request_context.scheme%://%router.request_context.host%%router.request_context.base_url%/_html_cli_dumper_data'
    disable_cli_dump:     false
```

If you have properly configured your global request context with the dedicated parameters (cf https://symfony.com/doc/current/console/request_context.html), and if you use the default `web` directory, then you're good to go with the default configuration.  

### Details

##### enabled
* Type : boolean
* Description : Enable the bundle ?

##### save_directory_path
* Type : string
* Description : The directory path where the HTML dumps are saved. If the directory doesn't exist, it will be created.

##### view_base_url
* Type : string
* Description : The base url that is prepended before the generated HTML dump unique id.

##### disable_cli_dump
* Type : boolean
* Description : Disable the cli dump output in the console ?
