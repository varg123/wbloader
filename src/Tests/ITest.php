<?php


namespace Tests;


interface ITest
{
    public function getName(): string;

    public function test(): array;
}