<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class BrandField implements IField
{

    protected $value = null;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * @param $card Card
     * @return Card
     */
    function applyField($card)
    {
        $value = $this->value;
        if ($this->barnds[$value]) {
            $card->addin[] = new Addin([
                'type' => 'Бренд',
                'params' => [
                    [
                        'value' => $this->barnds[$value]
                    ]
                ]
            ]);
        }
        return $card;
    }

    protected $barnds = [
        "OMAX" => "OMAX",
    ];
}