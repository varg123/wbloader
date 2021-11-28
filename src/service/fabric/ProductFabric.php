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
        /**
         * @var $offer Offer
         */
        $product = null;
        switch ($offer->category) {
            case 'будильники':
                $product = new AlarmClock($offer);
                break;
            case 'настольные часы':
            case 'напольные часы':
                $product = new TableClock($offer);
                break;
            case 'Настенные часы':
                $product = new WallClock($offer);
                break;
            case 'Мужские часы':
            case 'Женские часы':
            case 'Детские часы':
            case 'Часы наклейки':
            case 'Stailer':
                $product = new WristWatches($offer);
                break;
            case 'ремешки':
            case 'браслеты':
                $product = new BraceletsWatches($offer);
                break;
            case 'статуэтки':
                $product = new Figurines($offer);
                break;
            default:
                throw new \Exception("не описанная категория");
        }
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

        $product = null;
        switch ($offer->category) {
            case 'будильники':
                $product = new AlarmClock($offer);
                break;
            case 'настольные часы':
            case 'напольные часы':
                $product = new TableClock($offer);
                break;
            case 'Настенные часы':
                $product = new WallClock($offer);
                break;
            case 'Мужские часы':
            case 'Женские часы':
            case 'Детские часы':
            case 'Часы наклейки':
            case 'Stailer':
                $product = new WristWatches($offer);
                break;
            case 'ремешки':
            case 'браслеты':
                $product = new BraceletsWatches($offer);
                break;
            case 'статуэтки':
                $product = new Figurines($offer);
                break;
            default:
                throw new \Exception("не описанная категория");
        }
        return $product ? $product->getProduct($card) : false;
    }
}