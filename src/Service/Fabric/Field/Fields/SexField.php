<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class SexField implements IField
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
        if (!$this->sexValues[$value]) {
            $value = 'унисекс';
        }

        if ($this->sexValues[$value]) {
            $params = [];
            foreach ($this->sexValues[$value] as $prop) {
                $params[] = [
                    'value' => $prop
                ];
            }
            $card->addin[] = new Addin([
                'type' => 'Пол',
                'params' => $params
            ]);
        }
        return $card;
    }

    protected $sexValues = [
        "Мужской ремень CLASSIC" => [
            "Мужской",
        ],
        "Мужской браслет" => [
            "Мужской"
        ],
        "Женский браслет" => [
            "Женский"
        ],
        "Женский ремень" => [
            "Женский"
        ],
        "ЭЛЕКРОНИКА" => [
            "Мужской",
            "Женский",
            "Детский"
        ],
        "ЭЛИТНЫЕ часы  OMAX" => [
            "Женский",
            "Мужской",
            "Детский"
        ],
        "Мужской ремень PREMIUM" => [
            "Мужской",
        ],
        "Мужской ремень CLASSIC с календарем" => [
            "Мужской",
        ],
        "OMAX СЕТ (в коробке мужская и женская модель)" => [
            "Женский",
            "Мужской",
        ],
    ];
}