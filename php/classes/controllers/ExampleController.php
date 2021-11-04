<?php

class ExampleController extends ExampleModel
{
    function changeExample(string $var)
    {
        $this->example = $var;
    }
}