<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class MaterialBraceletWatchField implements IField
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
                'type' => 'Материал браслета',
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
        'нержавеющая сталь с PVD покрытием',
        'нержавеющая сталь и каучук',
        'пластиковый',
        'нержавеющая сталь',
        'полимерный',
        'нержавеющая сталь с IP покрытием',
        'латунь с PVD покрытием',
        'силиконовый',
        'текстильный на кожаной основе',
        'текстильный',
        'металл с PVD-покрытием',
        'металл с IP-покрытием',
        'латунь',
        'нержавеющая сталь с GEP покрытием',
        'нержавеющая сталь и керамика',
        'натуральная кожа',
        'керамический',
        'металл',
        'латунь с IP покрытием',
        'кожаный со вставками из текстиля',
        'металлический PVDпокрытием и пластиковыми ставками',
        'каучук',
        'латунь с покрытием PVD и керамика',
        'нержавеющая сталь и пластик',
        'титановый',
        'металл с PVD-покрытием и пластиковыми вставками',
        'пробковый',
        'нержавеющая сталь с IPG-покрытием',
    ];


}