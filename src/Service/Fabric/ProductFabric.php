<?php

namespace Service\Fabric;

use Service\DTO\Offer;
use Service\Fabric\Product\AlarmClock;
use Service\Fabric\Product\BraceletsWatches;
use Service\Fabric\Product\Figurines;
use Service\Fabric\Product\NullProduct;
use Service\Fabric\Product\TableClock;
use Service\Fabric\Product\WallClock;
use Service\Fabric\Product\WristWatches;
use WBApi\DTO\Card;

class ProductFabric
{
    static function createProduct($offer)
    {
        $product = new WristWatches($offer);
        return $product ? $product->getProduct() : false;
    }

    /**
     * @param $card Card
     * @param $offer Offer
     * @return NullProduct
     */
    static function updateProduct($card, $offer)
    {
        $card->addin=[];
        if ($card->nomenclatures) {
            $card->nomenclatures[0]->addin =[];
        }
        if ($card->nomenclatures[0]->variations) {
            $card->nomenclatures[0]->variations[0]->addin =[];
        }

        $product = new WristWatches($offer);
        return $product ? $product->getProduct($card) : false;
    }
}