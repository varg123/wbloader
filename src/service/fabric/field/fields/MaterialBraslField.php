<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class MaterialBraslField implements IField
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
        if ($this->material[$value]) {
            $card->addin[] = new Addin([
                'type' => 'Материал браслета',
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
        "Мужской ремень CLASSIC" => "кожаный",
        "Женский ремень" => "кожаный",
        "Мужской браслет" => "Сплав металла Alloy",
        "Женский браслет" => "Сплав металла Alloy",
        "ЭЛЕКРОНИКА" => "стекло",
        "ЭЛИТНЫЕ часы  OMAX" => "Сталь с PVD покрытием",
        "Мужской ремень PREMIUM" => "кожаный",
        "Мужской ремень CLASSIC с календарем" => "кожаный",
        "OMAX СЕТ (в коробке мужская и женская модель)" => "кожаный",
    ];
}