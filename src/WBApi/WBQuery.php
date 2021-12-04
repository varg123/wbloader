<?php

namespace WBApi;

use mysql_xdevapi\Exception;
use WBApi\DTO\Card;
use WBApi\DTO\ErrorResponse;
use WBApi\DTO\Info;
use WBApi\DTO\NullDto;
use WBApi\DTO\Price;
use WBApi\DTO\SuccessResponse;
use WBApi\Exception\RequestException;

class WBQuery
{
    private $curl = null;

    public function __construct($token)
    {
        $curl = new \Curl\Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setHeader('Authorization', $token);
        $this->curl = $curl;
    }

    public function prices($priceDtoArray)
    {
        /**
         * @var $item Price
         */
        foreach ($priceDtoArray as $item) {
            $param[] = [
                "nmId" => (int)$item->nmId,
                "price" => (int)$item->price
            ];
        }
        if ($param) {
            $res = $this->curl->post('https://suppliers-api.wildberries.ru/public/api/v1/prices', $param);
            $responce = json_decode($res, true);
            if ($this->curl->httpStatusCode == '200') {
                return true;
            }
            else {
                throw new \Exception(serialize($responce));
            }
        }
        return true;
    }

    public function info($quantity = 0)
    {
        $param = [
            'quantity' => $quantity
        ];
        if ($param) {
            $res = $this->curl->get('https://suppliers-api.wildberries.ru/public/api/v1/info', $param);
            $responce = json_decode($res, true);
            switch ($this->curl->httpStatusCode) {
                case '400':
                    return new ErrorResponse($responce);
                case '200':
                    $rez = [];
                    foreach ($responce as $item) {
                        $rez[] = new Info($item);
                    }
                    return $rez;
                default:
                    return new NullDto();
            }
        }
        return new NullDto();
    }

    public function getBarcodes($quantity = 1)
    {
        $param = [
            "jsonrpc" => "2.0",
            "params" => [
                'quantity' => $quantity
            ]
        ];
        if ($param) {
            $this->curl->post('https://suppliers-api.wildberries.ru/card/getBarcodes', $param);
            $responce = json_decode($this->curl->rawResponse, true);
            if ($this->curl->httpStatusCode = '200') {
                return $responce['result']['barcodes'];
            }
            throw new \Exception(serialize($responce));
        }
        return [];
    }

    public function stocksDelete($warehouseId, $barcodes)
    {
        $param = [];
        foreach ($barcodes as $barcode) {
            $param[] = [
                'barcode' => $barcode,
                'warehouseId' => $warehouseId,
            ];
        }
        if ($param) {
            $res = $this->curl->delete('https://suppliers-api.wildberries.ru/api/v2/stocks', [], $param);
            $responce = json_decode($this->curl->rawResponse, true);
            switch ($this->curl->httpStatusCode) {
                case '400':
                case '200':
                    return $responce['data'];
                default:
                    return new NullDto();
            }
        }
        return new NullDto();
    }

    public function stocks($warehouseId, $stoksArray)
    {
        $param = [];
        foreach ($stoksArray as $item) {
            $param[] = [
                'warehouseId' => $warehouseId,
                'barcode' => $item['barcode'],
                'stock' => (int)$item['stock'],
            ];
        }
        if ($param) {
            $res = $this->curl->post('https://suppliers-api.wildberries.ru/api/v2/stocks', $param);
            $responce = json_decode($this->curl->rawResponse, true);
            if ($this->curl->httpStatusCode == '200') {
                if ($responce['data']['errors']) {
                    throw new \Exception(serialize($responce['data']['errors']));
                }
            }
            return true;
        }
        return true;
    }

    public function cardList($find, $withError = false, $limit = 10, $offset = 0)
    {
        $findArr = [];
        foreach ($find as $item) {
            $findArr[] = $item->toArray();
        }
        $param = [
            "jsonrpc" => "2.0",
            'params' => [
                'filter' => [
                    'find' => $findArr,
                    'order' => [
                        "column" => "createdAt",
                        "order" => "asc"
                    ],
                    'query' => [
                        "limit" => $limit,
                        "offset" => $offset
                    ],
                    "withError" => $withError
                ]
            ]
        ];
        if ($findArr) {

//            print_r(json_encode($param));
            $res = $this->curl->post('https://suppliers-api.wildberries.ru/card/list', $param);
            $responce = json_decode($this->curl->rawResponse, true);
            if ($this->curl->httpStatusCode == '200') {
                $cards = [];
                foreach ($responce['result']['cards'] as $item) {
                    $cards[] = new Card($item);
                }
                return $cards;
            } else {
                new \Exception(serialize($responce));
            }
        }
        return [];
    }

    public function cardUpdate($card)
    {
        $param = [
            "id" => "1",
            "jsonrpc" => "2.0",
            'params' => [
                'card' => $card->toArray(),
            ]
        ];
        if ($card) {
            $this->curl->post('https://suppliers-api.wildberries.ru/card/update', $param);
            $responce = json_decode($this->curl->rawResponse, true);
            if ($this->curl->httpStatusCode == '200') {
                if ($responce['error']['message']) {
                    throw new \Exception($responce['error']['message']);
                }
                return $responce;
            } else {
                throw new \Exception(serialize($responce));
            }
        }
        return null;
    }

    public function cardCreate($card)
    {
        $param = [
            "id" => 1,
            "jsonrpc" => "2.0",
            'params' => [
                'card' => $card->toArray(),
            ]
        ];
        if ($card) {
            $res = $this->curl->post('https://suppliers-api.wildberries.ru/card/create', $param);
            $responce = json_decode($this->curl->rawResponse, true);
            if ($this->curl->httpStatusCode == '200') {
                if ($responce['error']['message']) {
                    throw new \Exception($responce['error']['message']);
                }
                return $responce;
            } else {
                throw new \Exception(serialize($responce));
            }
        }
        return null;
    }

    public function cardBatchCreate($cards)
    {
        $cardsArr = [];
        foreach ($cards as $card) {
            $cardsArr[] = $card->toArray();
        }
        $param = [
            "id" => 1,
            "jsonrpc" => "2.0",
            'params' => [
                'card' => $cardsArr,
            ]
        ];
        if ($cardsArr) {
            $res = $this->curl->post('https://suppliers-api.wildberries.ru/card/batchCreate', $param);
            $responce = json_decode($this->curl->rawResponse, true);
            switch ($this->curl->httpStatusCode) {
                case '200':
                    return $responce;
                default:
                    return new NullDto();
            }
        }
        return new NullDto();
    }

    public function deleteNomenclature($nomenclatureID)
    {
        $param = [
            "id" => 1,
            "jsonrpc" => "2.0",
            'params' => [
                'nomenclatureID' => $nomenclatureID,
            ]
        ];
        $res = $this->curl->post('https://suppliers-api.wildberries.ru/card/deleteNomenclature', $param);
        $responce = json_decode($this->curl->rawResponse, true);
        switch ($this->curl->httpStatusCode) {
            case '200':
                return true;
            default:
                return new NullDto();
        }
    }
}