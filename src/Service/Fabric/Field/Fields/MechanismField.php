<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class MechanismField implements IField
{

    protected $value = null;

    public function __construct($glass)
    {
        $this->value = $glass;
    }

    /**
     * @param $card Card
     * @return Card
     */
    function applyField($card)
    {
        $value = $this->value;
        if (in_array($value, array_keys($this->material))) {
            $card->addin[] = new Addin([
                'type' => 'Вид стекла',
                'params' => [
                    [
                        'value' => $this->material[$value]
                    ]
                ]
            ]);
        }
        return $card;
    }

    protected $material = [
        'электронный' => 'Электронный кварцевый',
        'механический' => 'механические',
        'кварцевый' => 'Кварцевый',
    ];



}