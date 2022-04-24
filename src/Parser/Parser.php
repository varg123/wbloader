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
            $offer['articul2'] = 'idkach' . $offer['id'];
            $offer['price'] = (string)((int)$offerData->price * 1.4);

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
                    case 'Код товара':
                        $offer['kod'] = (string)$param;
                        $articul = preg_replace('/[^A-Za-z0-9А-Яа-я\-]/ui', '_', $offer['kod']);
                        $offer['articul'] = $articul;
                        break;
                    case 'Механизм':
                        $offer['mechanism'] = (string)$param;
                        break;
                    case 'Материал корпуса':
                        $offer['materialBody'] = (string)$param;
                        break;
                    case 'Материал браслета':
                        $offer['materialBracelet'] = (string)$param;
                        break;
                    case 'Класс водозащиты':
                        $offer['protectionClass'] = (string)$param;
                        break;
                    case 'Форма':
                        $offer['form'] = (string)$param;
                        break;
                    case 'Цвет циферблата':
                        $offer['colorDial'] = (string)$param;
                        break;
                    case 'Цвет корпуса':
                        $offer['colorBody'] = (string)$param;
                        break;
                    case 'Цвет ремня/браслета':
                        $offer['colorBracelet'] = (string)$param;
                        break;
                    case 'Оформление цифр':
                        $offer['designNumbers'] = (string)$param;
                        break;
                    case 'Звук':
                        $offer['sound'] = (string)$param;
                        break;
                    case 'Гарантия':
                        $offer['guarantee'] = (string)$param;
                        break;
                    case 'Стекло':
                        $offer['glass'] = (string)$param;
                        break;
                    case 'Диаметр корпуса':
                        $offer['diameterBody'] = (string)$param;
                        break;
                    case 'Комплектность':
                        $offer['guration'] = (string)$param;
                        break;
                    case 'Пол':
                        $offer['sex'] = (string)$param;
                        break;
                    case 'Свойства':
                        $offer['propreties'] = (string)$param;
                        break;
                    case 'Календарь':
                        $offer['calendar'] = (string)$param;
                        break;
                    case 'Подсветка':
                        $offer['illumination'] = (string)$param;
                        break;
                    case 'Индикатор даты':
                        $offer['dateIndicator'] = (string)$param;
                        break;
                    case 'Секундомер':
                        $offer['stopwatch'] = (string)$param;
                        break;
                    case 'Батарея':
                        $offer['battery'] = (string)$param;
                        break;
                    case 'Функции':
                        $offer['functions'] = (string)$param;
                        break;
                    case 'Таймеры':
                        $offer['timers'] = (string)$param;
                        break;
                    case 'Длина ремешка':
                        $offer['lengthStrap'] = (string)$param;
                        break;
                    case 'Ширина ремешка':
                        $offer['widthStrap'] = (string)$param;
                        break;
                    case 'Длина большей части':
                        $offer['lengthMostPart'] = (string)$param;
                        break;
                    case 'Длина меньшей части без застежки':
                        $offer['lengthSmallPart'] = (string)$param;
                        break;
//                    case 'Описание для маркетов':
//                        $offer['mech'] = (string)$param;
//                        break;
                    case 'Особые функции':
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
//        if ($offerObj->id==81611) {
//            print_r($offerObj);
            return true;
//        }
//        return false;
    }
}