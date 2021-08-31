# Text Processing

Some general text processing functions.

## Requirements

* TextProc should work with any PHP version >= 7.4.

## Getting Started

Fork this repository from https://github.com/sfu-dhil/textproc and then clone it
to your computer. Install the dependencies with 

```shell
composer install
```

## Basic usage

There's a quick sample/wrapper script in `process`. It can be used for some 
quick debugging and checking. Use it like so:

```shell
$ php process "I am a banana!"
I am a banana!
$
```

To use the processor class in a project, 

1. Require the composer autoloader
2. Import the processor namespace
3. Create the object
4. Call some functions on the object

For example:

```php
require 'vendor/autoload.php'; // optional - an autoloader may already be set up

use Dhil\TextProc\Processor;

$processor = new Processor();
echo $processor->doStuff("some string");
```

## Development

Bug reports and feature requests are tracked on 
[GitHub](https://github.com/sfu-dhil/textproc/issues). Pull requests are always 
welcome.

### Testing

The project is configured to run the tests with the PHPUnit framework.

```shell
php vendor/bin/phpunit
```

Code coverage is also configured for this project.

```shell
php -d zend_extension=xdebug.so -d xdebug.mode=coverage \
  vendor/bin/phpunit -c phpunit.coverage.xml
```

This will generate a code coverage report in `coverage/`. To read it, open 
`coverage/index.html` in a browser. 100% code coverage is our goal, but we 
also understand that it isn't always achievable.

### Coding Standards

The project is configured with the usual DHIL coding standards, implemented as
a `php-cs-fixer` configuration. Apply the coding standards with 

```shell
php vendor/bin/php-cs-fixer fix
```
