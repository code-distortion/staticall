# Upgrade

## From [0.2.0] to [0.3.0]

### `$staticallPrefix` Property Removed

`0.3.0` removed the `$staticallPrefix` property. The method prefix is now always `staticall`.

If you use a custom prefix, you will need to change your method names.

To upgrade:
- remove the `$staticallPrefix` property from your classes,
- change the prefix your method names use to `staticall`.

Before:

``` php
<?php

use CodeDistortion\Staticall\Staticall;

class MyClass
{
    use Staticall;

    protected $staticallPrefix = 'customPrefix'; // <<<

    private function customPrefixMyMethod(): string // <<<
    {
        return 'hello';
    }
}
```

After:

``` php
<?php

use CodeDistortion\Staticall\Staticall;

class MyClass
{
    use Staticall;

    private function staticallMyMethod(): string // <<<
    {
        return 'hello';
    }
}
```



## From [0.1.0] to [0.2.0]

### Default Prefix

`0.2.0` changed the default prefix from `call` to `staticall`.

To upgrade, change the prefix your method names use.

Before:

``` php
<?php

use CodeDistortion\Staticall\Staticall;

class MyClass
{
    use Staticall;

    private function callMyMethod(): string // <<<
    {
        return 'hello';
    }
}
```

After:

``` php
<?php

use CodeDistortion\Staticall\Staticall;

class MyClass
{
    use Staticall;

    private function staticallMyMethod(): string // <<<
    {
        return 'hello';
    }
}
```
