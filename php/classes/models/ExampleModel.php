<?php

class ExampleModel
{
    protected string $example = "123";


    public function getExample(): string
    {
        return $this->example;
    }
}