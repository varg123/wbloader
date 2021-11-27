<?php

namespace Service\Fabric\Field;

use WBApi\DTO\Card;

class BaseField implements IField
{

    protected $value = null;
    public function __construct($value=null)
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
        $card->object = $value;
        return $card;
    }
}