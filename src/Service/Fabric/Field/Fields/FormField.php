<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class FormField implements IField
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
                'type' => 'Форма корпуса',
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
        'круглые' => 'круглые часы',
        'прямоугольные' => 'прямоугольные часы',
        'бочка' => 'Бочка',
        'квадратные' => 'Квадрат',
        'овальные' => 'овальные',
//        'другой формы' => '',
        'многоугольные' => 'многоугольник',
    ];


}