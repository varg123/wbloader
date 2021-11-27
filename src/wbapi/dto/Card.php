<?php


namespace WBApi\DTO;


use Spatie\DataTransferObject\DataTransferObject;

use Spatie\DataTransferObject\Attributes\CastWith;
class Card extends  DataTransferObject
{

    #[CastWith(\WBApi\DTO\AddinArrayCaster::class)]
    public  $addin;

    public  $countryProduction;
    public  $createdAt;
    public  $id;
    public  $imtId;
    public  $imtSupplierId;

    #[CastWith(\WBApi\DTO\NomenclatureArrayCaster::class)]
    public   $nomenclatures;

    public $object;
    public $parent;
    public $supplierId;
    public $supplierVendorCode;
    public $updatedAt;
    public $uploadID;
    public $userId;


}