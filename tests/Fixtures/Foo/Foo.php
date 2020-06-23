<?php

namespace Tests\Fixtures\Foo;

abstract class Foo implements FooInterface
{
    protected const C_FOO = 'C_FOO';

    protected $bar = 'bar';

    protected static $barStatic = 'barStatic';

    final protected function getBar()
    {
        return $this->bar;
    }

    private static function getBarStatic()
    {
        return self::$barStatic;
    }

    abstract public function foo();
}
