<?php


namespace WBApi\DTO;


use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class Variation extends DataTransferObject
{
    #[CastWith(\WBApi\DTO\AddinArrayCaster::class)]
    public $addin;
    public $barcode;
    public $barcodes;
    public $chrtId;
    public $errors;
    public $id;
}