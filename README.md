# Staticall

[![Latest Version on Packagist](https://img.shields.io/packagist/v/code-distortion/staticall.svg?style=flat-square)](https://packagist.org/packages/code-distortion/staticall)
![PHP Version](https://img.shields.io/badge/PHP-7.0%20to%208.2-blue?style=flat-square)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/code-distortion/staticall/run-tests.yml?branch=master&style=flat-square)](https://github.com/code-distortion/staticall/actions)
[![Buy The World a Tree](https://img.shields.io/badge/treeware-%F0%9F%8C%B3-lightgreen?style=flat-square)](https://plant.treeware.earth/code-distortion/staticall)
[![Contributor Covenant](https://img.shields.io/badge/contributor%20covenant-v2.0%20adopted-ff69b4.svg?style=flat-square)](CODE_OF_CONDUCT.md)

***code-distortion/staticall*** is a package for that lets you call methods statically and non-statically.



## Installation

Install the package via composer:

``` bash
composer require code-distortion/staticall
```



## Usage

- Include the `Staticall` trait in your class
- Add methods to your class, with the prefix `call`

``` php
<?php

use CodeDistortion\Staticall\Staticall;

class MyClass
{
    use Staticall;

    private function callMyMethod(): string
    {
        return 'hello';
    }
}
```

``` php
MyClass::myMethod(); // "hello"

$myObject = new MyClass();
$myObject->myMethod(); // "hello"
```

When a method is called statically like this, Staticall will instantiate the class first, and call the method against that.

This is useful for classes that have optional methods for chaining. Any of the methods can be called first.

``` php
MyClass::recipient('Bob', 'bob@test.com')->send();
MyClass::attach('file.zip')->recipient('Bob', 'bob@test.com')->send();
```

***Note:*** The constructor of your class must not accept any parameters.

***Note:*** Staticall makes the methods it finds, publicly accessible.

Your can change the method prefix by adding static property $staticallPrefix to your class.

``` php
<?php

use CodeDistortion\Staticall\Staticall;

class MyClass
{
    use Staticall;
    
    protected static $staticallPrefix = 'xyz';

    private function xyzMyMethod(): string
    {
        return 'hello';
    }
}
```



## Testing

``` bash
composer test
```



## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.



### SemVer

This library uses [SemVer 2.0.0](https://semver.org/) versioning. This means that changes to `X` indicate a breaking change: `0.0.X`, `0.X.y`, `X.y.z`. When this library changes to version 1.0.0, 2.0.0 and so forth it doesn't indicate that it's necessarily a notable release, it simply indicates that the changes were breaking.



## Treeware

This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**](https://plant.treeware.earth/code-distortion/staticall) to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.



## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.



### Code of Conduct

Please see [CODE_OF_CONDUCT](.github/CODE_OF_CONDUCT.md) for details.



### Security

If you discover any security related issues, please email tim@code-distortion.net instead of using the issue tracker.



## Credits

- [Tim Chandler](https://github.com/code-distortion)



## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
