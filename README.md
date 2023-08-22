# Generator robots.txt
Generator of the text file "robots.txt"

***The robots.txt*** file is a text file located in the root directory of the site, in which special instructions for search robots are written. These instructions may prohibit some sections or pages on the site from being indexed, indicate the correct "mirroring" of the domain, recommend the search robot to observe a certain time interval between downloading documents from the server, etc.

## Installation
First, install the package via composer:
```
composer require jazzman/php-robots
```
Or add the following to your ```composer.json``` in the require section and then run ```composer``` update to install it.

```json
{
    "require": {
        "jazzman/php-robots": "2.0"
    }
}
```

## Usage

### default

```php
use JazzMan\Robots\Robots;
use JazzMan\Robots\RobotsInterface;

Robots::getInstance()
    ->host("www.site.com")
    ->userAgent("*")
    ->allow("one","two")
    ->disallow("one","two","three")
    ->each(function (RobotsInterface $robots) {
        $robots->userAgent("Google")
            ->comment("Comment Google")
            ->spacer()
            ->allow("testing");
    })->each(function (RobotsInterface $robots) {
        $robots->userAgent("Bind")
            ->comment("Comment Bind")
            ->spacer()
            ->allow("testing");
    })->create(); // or render()

```

## Testing

```
$ phpunit
```