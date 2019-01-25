<?php

namespace Violinist\ProjectData\Tests\Unit;

class DummyField
{
    private $string;

    public function first()
    {
        return $this;
    }

    public function isEmpty()
    {
        return empty($this->string);
    }

    public function getString()
    {
        return $this->string;
    }

    public function setString($value)
    {
        $this->string = $value;
    }
}
