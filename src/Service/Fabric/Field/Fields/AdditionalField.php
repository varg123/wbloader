<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class AdditionalField implements IField
{

    protected $value = null;
    protected $name = null;

    public function __construct($name,$array)
    {
        $this->name = $name;
        $this->value = $array;
    }

    /**
     * @param $card Card
     * @return Card
     */
    function applyField($card)
    {
        $value = $this->value;
        $name = $this->name;
        $res = [];
        foreach ($value as $itemValue) {
            if (empty($res)) {
                $res = [
                    'type' => $name,
                    'params' => []
                ];
            }
            if ($itemValue and count($res['params'])<3) {
                $res['params']+= [
                    'value' => $itemValue
                ];
            }
            else {
                break;
            }
        }
        print_r("test");
        if ($res) {
            $card->addin[] = new Addin($res);
        }
        return $card;
    }

}