# thememanager

## Installation

```
composer require webinertia/webinertia-thememanager
```

### Post install setup

After installing the module for the first time your application will not render until you run the build command. This command restructers
the directories to the proper structure (as detailed below).

```php
php ./vendor/bin/laminas thememanager:build-theme
```

```src/
    view/
        default/ <- theme directory - this is really the only change
            application/ <- as you can see this is back to the default structure module directory
                index/ <- controller directory
                    index.phtml <- action view files
```

With this module installed and the above changes made Laminas will then support multiple themes allowing you to prototype faster
since you can then have

```src/
    view/
        default/
        dark/
        light/
        blue/
```

#### Important note about public assets

Only the default css, img and js folders will be moved. In a future release we may expand that. You will need to update your layouts to match the new paths. In a future release we will most likely automate this.

```text
/public/theme/default
                /css
                /img
                /js
```
