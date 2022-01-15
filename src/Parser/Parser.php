<?php

namespace Parser;

use DB\MysqlConnection;
use Service\DTO\Offer;

class Parser implements \Parser\IParser
{
    private $url;

    public function __construct($url)
    {
//        $this->url = 'C:\Users\Professional\Desktop\index.xml';
        $this->url = $url;
    }

    public function getData(): array
    {

        $result = [];
        $xlmData = file_get_contents($this->url);
        $xml = new \SimpleXMLElement($xlmData, LIBXML_COMPACT | LIBXML_PARSEHUGE);

        $categories = $xml->xpath('/yml_catalog/shop/categories/category');
        foreach ($categories as $categoty) {
            $result['categories'][(string)$categoty->attributes()['id']] = trim((string)$categoty[0]);
        }
        unset($result['categories'][66]);

        $categoryIds = array_keys($result['categories']);
        $offers = $xml->xpath('/yml_catalog/shop/offers/offer');
        $resultOffers = [];
        foreach ($offers as $offerData) {
            $offer = [];
            $offer['id'] = (string)$offerData->attributes()['id'];
            $offer['available'] = (int)$offerData->attributes()['available'];
            $offer['articul'] = 'IDTest' . $offer['id'];
            $offer['articul2'] = 'idTest1' . $offer['id'];
            $offer['price'] = (int)($offerData->price*1.1);

            foreach ((array)$offerData->categoryId as $categoryId) {
                $categoryId = (string)$categoryId;
                if (in_array($categoryId, $categoryIds)) {
                    $offer['categoryId'] = $categoryId;
                    $offer['category'] = $result['categories'][$categoryId];
                    break;
                }
            }

            $offer['currency'] = (string)$offerData->currencyId;
            $offer['store'] = (string)$offerData->store;
            $offer['pickup'] = (string)$offerData->pickup;
            $offer['delivery'] = (string)$offerData->delivery;
            $offer['name'] = (string)$offerData->name;
            $offer['vendor'] = (string)$offerData->vendor;
            $offer['vendorCode'] = preg_replace('/[^A-z0-9]*/u', '', (string)$offerData->vendorCode);
            $offer['articul2'] = $offer['vendorCode'];
            $offer['model'] = (string)$offerData->model;
            $offer['articul'] = preg_replace('/[^A-z0-9]*/u', '', (string)$offerData->model);

            $offer['description'] = (string)$offerData->description;


            $url = (string)$offerData->url;
            if ($url) {
                $offer['url'] = str_replace('&amp;', '&', $url);
            }

            foreach ($offerData->xpath('picture') as $picture) {
                $offer['picture'][] = (string)$picture;
            }

            $offerObj = new Offer($offer);
            if ($this->filterOffers($offerObj)) {
                $resultOffers[] = $offerObj;
            }
        }
        return $resultOffers;
    }

    /**
     *
     * @param $offerObj Offer
     * @return bool
     */
    protected function filterOffers($offerObj)
    {
//        if (in_array($offerObj->id, [7279])) {
//            return true;
//        }
        return true;
    }
}