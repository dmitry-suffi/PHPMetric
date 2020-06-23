<?php

namespace Tests\Fixtures\Foo;

trait FooTrait
{
    protected $tFoo = 'tFoo';

    public function tFoo()
    {
        return $this->tFoo;
    }
}
