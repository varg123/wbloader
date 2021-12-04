<?php


namespace WBApi\DTO;


use Spatie\DataTransferObject\DataTransferObject;
//use \Spatie\DataTransferObject\;


use Spatie\DataTransferObject\Attributes\CastWith;
class Addin extends DataTransferObject
{
    #[CastWith(\WBApi\DTO\ParameterArrayCaster::class)]
    public $params;
    public $type;
}
