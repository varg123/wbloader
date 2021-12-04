<?php


namespace WBApi\DTO;


use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class Nomenclature  extends DataTransferObject
{
    #[CastWith(\WBApi\DTO\AddinArrayCaster::class)]
    public  $addin;
    public  $concatVendorCode;
    public  $id;
    public  $isArchive;
    public  $nmId;
    #[CastWith(\WBApi\DTO\VariationArrayCaster::class)]
    public  $variations;
    public  $vendorCode;
}