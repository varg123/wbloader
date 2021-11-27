<?php


namespace DB;


use Spatie\DataTransferObject\DataTransferObject;

class Info extends DataTransferObject
{
    public $id;
    public $nmId;
    public $price;
    public $outlet;
    public $articul;
    public $hash;
    public $lastError;
    public $lastErrorDate;
    public $barcode;
}

