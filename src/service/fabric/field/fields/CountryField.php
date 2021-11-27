<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class CountryField implements IField
{

    protected $value = null;

    public function __construct($vendor = null)
    {
        $this->value = $vendor;
    }

    /**
     * @param $card Card
     * @return Card
     */
    function applyField($card)
    {
        $value = $this->value;
        if ($this->countries[$value]) {
            $card->countryProduction = $this->countries[$value];
        }
        return $card;
    }

    protected $countries = [
        "OMAX" => "Китай",
    ];
}