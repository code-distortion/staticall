# Upgrade

## From [0.1.0] to [0.2.0]

### Default prefix

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
