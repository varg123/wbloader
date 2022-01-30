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
            $offer['articul2'] = 'idkr' . $offer['id'];
            $offer['price'] = (string)((int)$offerData->price * 1.3);

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
                if ((string)$param->attributes()['name'] != 'Цвет корпуса') {
                    $offer['params'][(string)$param->attributes()['name']] = str_replace(' | ', ', ', (string)$param);
                }
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

//        var_dump(mb_strlen("Браслет BS-83801 Серебристый стальной литой металлический для наручных часов 18 20 22 мм из стали не"));
//        die();
//        $ar = [
//            1288,
//            2440,
//            26576,
//            49465,
//            64080,
//            75278,
//            77684,
//            84348,
//            86906,
//            87721,
//            88456,
//            89283,
//            89286,
//            89547,
//            93216,
//            95100,
//            95300,
//            95315,
//            96864,
//            96867,
//            96868,
//            97101,
//            98498,
//            98504,
//            98507,
//            98519,
//            98521,
//            98526,
//            98529,
//            99747,
//            99748,
//            99749,
//            99751,
//            99778,
//            100315,
//            100521,
//            100523,
//            100637,
//            100640,
//            100643,
//            100968,
//            101105,
//            101106,
//            101749,
//            101750,
//            101751,
//            101752,
//            101753,
//            102104,
//            102130,
//            102134,
//            102140,
//            102146,
//            102495,
//            102810,
//            102823,
//            102824,
//            102827,
//            102838,
//            102862,
//            102864,
//            102865,
//            102988,
//            103000,
//            103751,
//            103967,
//            103968,
//            103970,
//            103972,
//            104588,
//            105025,
//            105027,
//            105438,
//            105440,
//            105445,
//            105451,
//            106018,
//            106026,
//            106028,
//            106031,
//            106032,
//            106033,
//            106034,
//            106759,
//            106796,
//            106823,
//            106824,
//            106825,
//            106828,
//            106857,
//            106858,
//            106859,
//            106860,
//            106861,
//            106867,
//            106868,
//            106869,
//            106872,
//            107276,
//            107504,
//            107634,
//            107644,
//            107648,
//            107927,
//            108179,
//            108186,
//            108213,
//            109206,
//            110177,
//            110427,
//            111221,
//
//        ];
//
////        $ar2 = [
////            79300
////        ];
///
        $ar = [
            1288,
            2440,
            48086,
            65112,
            79171,
            87225,
            88272,
            89806,
            89812,
            89818,
            90152,
            97101,
            97825,
            97826,
            99778,
            100422,
            100423,
            104700,
            105445,
            105498,
            108213,
            109206,
            110177,
            110427,
            111221,


        ];
//
        if (in_array($offerObj->id, $ar)) {
            return true;
        }
        return false;
    }
}