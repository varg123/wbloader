<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class KeysField implements IField
{

    protected $value = null;

    public function __construct($value)
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
        $params = [];
        $i=0;
        foreach ($value as $key) {
            $params[] = [
                'value' => $key
            ];
            $i+=1;
            if($i>2) break;
        }
//        $card->addin[] = new Addin([
//            'type' => "Ключевые слова",
//            'params' => $params
//        ]);
        return $card;
    }
}