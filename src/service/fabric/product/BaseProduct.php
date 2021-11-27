<?php


namespace Service\Fabric\Product;


use WBApi\DTO\Card;

abstract class BaseProduct implements IProductCreator
{

    protected $fields = [];
    function getFields()
    {
        return $this->fields;
    }

    function getProduct($card = null)
    {
        if (!$card) {
            $card = new Card();
        }
        foreach ($this->getFields() as $field) {
            $card  = $field->applyField($card);
        }
        return $card;
    }
}