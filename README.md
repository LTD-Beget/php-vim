# Php vim helper

[![Latest Stable Version](https://poser.pugx.org/ltd-beget/php-vim/version)](https://packagist.org/packages/ltd-beget/php-vim) 
[![Total Downloads](https://poser.pugx.org/ltd-beget/php-vim/downloads)](https://packagist.org/packages/ltd-beget/php-vim)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LTD-Beget/php-vim/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LTD-Beget/php-vim/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/LTD-Beget/php-vim/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/LTD-Beget/php-vim/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/LTD-Beget/php-vim/badges/build.png?b=master)](https://scrutinizer-ci.com/g/LTD-Beget/php-vim/build-status/master)
[![Documentation](https://img.shields.io/badge/code-documented-brightgreen.svg)](http://ltd-beget.github.io/php-vim/documentation/html/index.html)
[![Documentation](https://img.shields.io/badge/code-coverage-brightgreen.svg)](http://ltd-beget.github.io/php-vim/coverage/index.html)
[![License MIT](http://img.shields.io/badge/license-MIT-blue.svg?style=flat)](https://github.com/LTD-Beget/php-vim/blob/master/LICENSE)



Console helper for php to open vim in script, gives it control and returns control to script after close vim

## Installation

```shell
composer require ltd-beget/php-vim
```

## Usage
```php
<?php
    use LTDBeget\vim\Options;
        use LTDBeget\vim\Vim;
        
        require(__DIR__ . '/vendor/autoload.php');
    
        $vim = new Vim(
            (new Options())->setDiffMode(true)->setReadonlyMode(true)
        );
        $vim->addFileContent('a.txt', 'some text')->addFileContent('b.txt', 'some text2')->execute();
    
    
        $vim = new Vim;
        $vim->addFileContent('a.txt', 'some text')->execute();
        $vim->getContent('a.txt');
```

## Developers

### Regenerate documentation
```shell
$ ./vendor/bin/phpdox
```

### Run tests

```shell
$ wget https://phar.phpunit.de/phpunit.phar
```

```shell
$ php phpunit.phar --coverage-html coverage
```

```shell
$ php phpunit.phar --coverage-clover coverage.xml
```

## License
released under the MIT License.
See the [bundled LICENSE file](LICENSE) for details.
