<?php


namespace WBApi\DTO;


use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\DataTransferObject;

class Parameter extends DataTransferObject
{
    public  $count;
    public  $units;
    public  $value;
}