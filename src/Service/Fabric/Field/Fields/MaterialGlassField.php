<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class MaterialGlassField implements IField
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
//        $value = $this->value;
        $card->addin[] = new Addin([
            'type' => 'Материал стекла',
            'params' => [
                [
                    'value' => 'стекло'
                ]
            ]
        ]);
        return $card;
    }
}