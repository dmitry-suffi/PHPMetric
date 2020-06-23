<?php

namespace Tests\Fixtures\Foo;

trait FooTrait
{
    protected $t_foo = 't_foo';

    public function t_foo()
    {
        return $this->t_foo;
    }
}