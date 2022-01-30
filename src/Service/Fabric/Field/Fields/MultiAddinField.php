<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class MultiAddinField implements IField
{

    protected $values = null;
    protected $name = null;

    public function __construct($name, $values)
    {
        $this->values = $values;
        $this->name = $name;
    }

    /**
     * @param $card Card
     * @return Card
     */
    function applyField($card)
    {
        $values = $this->values;
        $name = $this->name;


        $params = [];
        $i=0;
        foreach ($values as $option) {
            if ($option) {
                $params[] = [
                    'value' => $option
                ];
                $i+=1;
            }
            if ($i>3) break;
        }

        if ($params) {
            $card->addin[] = new Addin([
                'type' => $name,
                'params' => $params
            ]);
        }

        return $card;
    }

}