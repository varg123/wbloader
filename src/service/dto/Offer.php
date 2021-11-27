<?php


namespace Service\DTO;


use Spatie\DataTransferObject\DataTransferObject;

class Offer extends DataTransferObject
{

    public $barcode;
    public $articul;
    public $articul2;


    public $id;
    public $price;
    public $category;
    public $available;
    public $picture;
    public $currency;
    public $store;
    public $pickup;
    public $delivery;
    public $name;
    public $vendor;
    public $vendorCode;
    public $model;
    public $description;
    public $url;

}

