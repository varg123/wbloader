<?php

namespace Parser;

use Service\DTO\Offer;

class Parser implements \Parser\IParser
{
    private $url;

    public function __construct($url)
    {
//        $this->url = 'C:\Users\Professional\Desktop\yml_export.xml';
        $this->url = $url;
    }

    public function getData(): array
    {

        $result = [];
        $xlmData = file_get_contents($this->url);
        $xml = new \SimpleXMLElement($xlmData, LIBXML_COMPACT | LIBXML_PARSEHUGE);

        $categories = $xml->xpath('/yml_catalog/shop/categories/category');
        foreach ($categories as $categoty) {
            $result['categories'][(string)$categoty->attributes()['id']] = (string)$categoty[0];
        }
        $categoryIds = array_keys($result['categories']);
        $offers = $xml->xpath('/yml_catalog/shop/offers/offer');
        $resultOffers = [];
        foreach ($offers as $offerData) {
            $offer = [];
            $offer['id'] = (string)$offerData->attributes()['id'];
            $offer['articul2'] = 'id'.$offer['id'];

            foreach ((array)$offerData->categoryId as $categoryId) {
                $categoryId = (string)$categoryId;
                if (in_array($categoryId, $categoryIds)) {
                    $offer['categoryId'] = $categoryId;
                    $offer['category'] = $result['categories'][$categoryId];
                    break;
                }
            }

            $offer['name'] = (string)$offerData->name;
            $offer['vendor'] = (string)$offerData->vendor;
            if ($offer['vendor']=='STAILER') {
                $offer['price'] = (string)((int)$offerData->price*1.3);
            }
            else {
                $offer['price'] = (string)((int)$offerData->price);
            }
            $offer['typePrefix'] = (string)$offerData->typePrefix;
            $offer['barcode'] = (string)$offerData->barcode;
            $offer['picture'] = (array)$offerData->picture;
            $offer['vat'] = (array)explode(',', $offerData->vat);
            $offer['description'] = (string)$offerData->description;
            $offer['outlet'] = (string)$offerData->outlet;
            $offer['weight'] = (string)$offerData->weight;
            $offer['dimensions'] = (string)$offerData->dimensions;
            $offer['length'] = (string)$offerData->length;
            $offer['width'] = (string)$offerData->width;
            $offer['height'] = (string)$offerData->height;
            foreach ($offerData->xpath('param') as $param) {
                $offer['params'][(string)$param->attributes()['name']] = str_replace(' | ', ', ', (string)$param);
                switch ((string)$param->attributes()['name']) {
                    case '?????? ????????????':
                        $offer['kod'] = (string)$param;
                        $articul = preg_replace('/[^A-Za-z0-9??-????-??\-]/ui', '_', $offer['kod']);
                        $offer['articul'] = $articul;
                        break;
                    case '????????????????':
                        $offer['mechanism'] = (string)$param;
                        break;
                    case '???????????????? ??????????????':
                        $offer['materialBody'] = (string)$param;
                        break;
                    case '???????????????? ????????????????':
                        $offer['materialBracelet'] = (string)$param;
                        break;
                    case '?????????? ????????????????????':
                        $offer['protectionClass'] = (string)$param;
                        break;
                    case '??????????':
                        $offer['form'] = (string)$param;
                        break;
                    case '???????? ????????????????????':
                        $offer['colorDial'] = (string)$param;
                        break;
                    case '???????? ??????????????':
                        $offer['colorBody'] = (string)$param;
                        break;
                    case '???????? ??????????/????????????????':
                        $offer['colorBracelet'] = (string)$param;
                        break;
                    case '???????????????????? ????????':
                        $offer['designNumbers'] = (string)$param;
                        break;
                    case '????????':
                        $offer['sound'] = (string)$param;
                        break;
                    case '????????????????':
                        $offer['guarantee'] = (string)$param;
                        break;
                    case '????????????':
                        $offer['glass'] = (string)$param;
                        break;
                    case '?????????????? ??????????????':
                        $offer['diameterBody'] = (string)$param;
                        break;
                    case '??????????????????????????':
                        $offer['guration'] = (string)$param;
                        break;
                    case '??????':
                        $offer['sex'] = (string)$param;
                        break;
                    case '????????????????':
                        $offer['propreties'] = (string)$param;
                        break;
                    case '??????????????????':
                        $offer['calendar'] = (string)$param;
                        break;
                    case '??????????????????':
                        $offer['illumination'] = (string)$param;
                        break;
                    case '?????????????????? ????????':
                        $offer['dateIndicator'] = (string)$param;
                        break;
                    case '????????????????????':
                        $offer['stopwatch'] = (string)$param;
                        break;
                    case '??????????????':
                        $offer['battery'] = (string)$param;
                        break;
                    case '??????????????':
                        $offer['functions'] = (string)$param;
                        break;
                    case '??????????????':
                        $offer['timers'] = (string)$param;
                        break;
                    case '?????????? ??????????????':
                        $offer['lengthStrap'] = (string)$param;
                        break;
                    case '???????????? ??????????????':
                        $offer['widthStrap'] = (string)$param;
                        break;
                    case '?????????? ?????????????? ??????????':
                        $offer['lengthMostPart'] = (string)$param;
                        break;
                    case '?????????? ?????????????? ?????????? ?????? ????????????????':
                        $offer['lengthSmallPart'] = (string)$param;
                        break;
//                    case '???????????????? ?????? ????????????????':
//                        $offer['mech'] = (string)$param;
//                        break;
                    case '???????????? ??????????????':
                        $offer['specialFunctions'] = (string)$param;
                        break;
                }
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

//        if (in_array($offerObj->id,[110202])) {
            return true;
//        }
//        return false;
    }
}