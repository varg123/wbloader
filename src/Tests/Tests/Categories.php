<?php

namespace Tests\Tests;

use Service\DTO\Offer;
use Tests\ITest;

class Categories implements ITest
{

    private $offers;

    public function __construct($offers)
    {
        $this->offers = $offers;
    }

    public function getName(): string
    {
        return 'Набор категорий';
    }

    public function test(): array
    {
        $result = [];
        $offers = $this->offers;
        $categories = $this->categories;
        $errors = [];

        /**
         * @var $offer Offer
         */
        foreach ($offers as $offer) {
            $result[] = $offer->category;
        }
        $result = array_unique($result);
        $resVal = array_diff($result, $categories);

        if ($resVal) {
            $errors[]= "лишние категории: ".implode($resVal);
        }
        return $errors;
    }

    private $categories = [
        "Настенные часы",
        "Мужские часы",
        "Женские часы",
        "будильники",
        "Детские часы",
        "настольные часы",
        "ремешки",
        "Автопроставки",
    ];

}