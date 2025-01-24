# Staticall

[![Latest Version on Packagist](https://img.shields.io/packagist/v/code-distortion/staticall.svg?style=flat-square)](https://packagist.org/packages/code-distortion/staticall)
![PHP Version](https://img.shields.io/badge/PHP-7.0%20to%208.4-blue?style=flat-square)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/code-distortion/staticall/run-tests.yml?branch=master&style=flat-square)](https://github.com/code-distortion/staticall/actions)
[![Buy The World a Tree](https://img.shields.io/badge/treeware-%F0%9F%8C%B3-lightgreen?style=flat-square)](https://plant.treeware.earth/code-distortion/staticall)
[![Contributor Covenant](https://img.shields.io/badge/contributor%20covenant-v2.1%20adopted-ff69b4.svg?style=flat-square)](.github/CODE_OF_CONDUCT.md)

***code-distortion/staticall*** is a package for that lets you call methods statically and non-statically.



## Installation

Install the package via composer:

```bash
composer require code-distortion/staticall
```



## Usage

- Include the `Staticall` trait in your class
- Add methods to your class with the prefix `staticall`

```php
use CodeDistortion\Staticall\Staticall; // <<<

class MyClass
{
    use Staticall; // <<<

    private function staticallMyMethod(): string // <<<
    {
        return 'hello';
    }
}
```

```php
MyClass::myMethod(); // "hello"

// is equivalent to

$myObject = new MyClass();
$myObject->myMethod(); // "hello"

// (both will work)
```

When a method is called statically like this, Staticall will instantiate the class first, and call the method against that.

This is useful for classes that have optional methods for chaining and any of the methods can be called first. e.g.

```php
MyEmail::recipient('Bob', 'bob@test.com')->send();
MyEmail::attach('file.zip')->recipient('Bob', 'bob@test.com')->send();
```

> ***Note:*** Because Staticall calls your constructor automatically, the constructor must not have any required parameters.

> ***Note:*** Staticall makes the methods it finds accessible *publicly*.



### Detecting Static Calls

If you'd like to check if your method was called statically, call the `$this->staticallMethodCallWasStatic()` method.

```php
use CodeDistortion\Staticall\Staticall;

class MyClass
{
    use Staticall;

    private function staticallMyMethod(): string
    {
        return $this->staticallMethodCallWasStatic() // <<<
            ? 'called statically'
            : 'called non-statically';
    }
}
```

```php
MyClass::myMethod();   // 'called statically'

$myObject = new MyClass();
$myObject->myMethod(); // 'not called statically'
```



### Caveats When Using Staticall

#### Passing Parameters By Reference

Staticall uses PHP's `__call()` and `__callStatic()` magic methods to intercept method calls, and subsequently call the correct method.

Unfortunately PHP doesn't support the passing of parameters by reference in this way. This means that if you have a method that expects a parameter to be passed by reference, you won't be able to call it using Staticall.

The [PHP RFC: Allow explicit call-site pass-by-reference annotation](https://wiki.php.net/rfc/explicit_send_by_ref) was proposed in 2017 to try to address this, but it has become inactive.



#### Calling Nested Staticall Methods Statically

Calling a method statically using Staticall is not quite the same as calling a true static method. The way you call it is the same, but behind the scenes it's a little different. Staticall instantiates a new instance of the class and calls the method non-statically against that. This means that the method is not *actually* running in a static context. If you call another Staticall method from within your method statically, it will actually be called non-statically.

```php
use CodeDistortion\Staticall\Staticall;

class MyClass
{
    use Staticall;

    private function staticallMyMethodA(): array
    {
        $calledStatically = $this->staticallMethodCallWasStatic()
            ? 'called statically'
            : 'called non-statically';

        return [
            'myMethodA' => $calledStatically,
            'myMethodB' => $this->myMethodB(), // <<<
        ];
    }

    private function staticallMyMethodB(): string
    {
        return $this->staticallMethodCallWasStatic()
            ? 'called statically'
            : 'called non-statically';
    }
}
```

```php
MyClass::myMethodA();
// [ 'myMethodA' => 'called statically',
//   'myMethodB' => 'called non-statically' ]
```

To counteract this, you can proxy the call via another method in the same class that *is* actually static.



## Testing This Package

- Clone this package: `git clone https://github.com/code-distortion/staticall.git .`
- Run `composer install` to install dependencies
- Run the tests: `composer test`



## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.



### SemVer

This library uses [SemVer 2.0.0](https://semver.org/) versioning. This means that changes to `X` indicate a breaking change: `0.0.X`, `0.X.y`, `X.y.z`. When this library changes to version 1.0.0, 2.0.0 and so forth, it doesn't indicate that it's necessarily a notable release, it simply indicates that the changes were breaking.



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
