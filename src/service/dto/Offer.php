<?php


namespace Service\DTO;


use Spatie\DataTransferObject\DataTransferObject;

class Offer extends DataTransferObject
{
    public $id;
    public $price;
    public $category;
    public $name;
    public $vendor;
    public $typePrefix;
    public $picture;
    public $vat;
    public $description;
    public $dimensions;
    public $salesNotes;
    public $length;
    public $weight;
    public $width;
    public $height;
    public $outlet;

    public $params;


    public $barcode;
    public $articul;
    public $articul2;

    //params
    public $kod;
    public $mechanism;
    public $materialBody;
    public $materialBracelet;
    public $protectionClass;
    public $form;
    public $colorDial;
    public $colorBody;
    public $colorBracelet;
    public $designNumbers;
    public $sound;
    public $guarantee;
    public $glass;
    public $diameterBody;
    public $guration;
    public $sex;
    public $propreties;
    public $calendar;
    public $illumination;
    public $dateIndicator;
    public $stopwatch;
    public $battery;
    public $functions;
    public $timers;
    public $lengthStrap;
    public $widthStrap;
    public $lengthMostPart;
    public $lengthSmallPart;
    public $specialFunctions;

}

