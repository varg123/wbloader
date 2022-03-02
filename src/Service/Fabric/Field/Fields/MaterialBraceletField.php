<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class MaterialBraceletField implements IField
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
        if (in_array($value, $this->material)) {
            $card->addin[] = new Addin([
                'type' => 'Материал браслета, ремешка',
                'params' => [
                    [
                        'value' => $value
                    ]
                ]
            ]);
        }
        return $card;
    }

    protected $material = [
        'кожаный',
        'натуральная кожа',
        'натуральная кожа + силикон',
        'каучук',
        'нейлон',
        'нержавеющая сталь',
        'натуральная кожа крокодила',
    ];
}