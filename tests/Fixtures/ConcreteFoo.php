<?php

namespace Tests\Fixtures;

use Tests\Fixtures\Foo\Foo;
use Tests\Fixtures\Foo\FooTrait;

class ConcreteFoo extends Foo
{
    use FooTrait;

    private $foo;

    protected $barNew;

    public function foo()
    {
        return 'foo';
    }

    private function _foo()
    {
        return 'foo';
    }
}
