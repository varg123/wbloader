<?php

use DB\MysqlConnection;
use Tests\TestContainer;
use Tests\Tests\Categories;
use Tests\Tests\ProductParams;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
function myAutoLoader(string $className)
{
    require_once __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';
}

spl_autoload_register('myAutoLoader');
error_reporting(E_ERROR | E_PARSE);

//print_r("test");


function test()
{
    $config = new \Config\AppConfig(__DIR__ . "/config.json");
    $url = $config->get("url");
    $parser = new \Parser\Parser($url);

    $offers = $parser->getData();

    /**
     * @var $offer \Service\DTO\Offer
     */
    $result = [];
    foreach ($offers as $offer) {
        if (is_null($result[$offer->category])) {
            $result[$offer->category] = [];
        }
        $result[$offer->category] += array_keys($offer->params);
        $result[$offer->category] = array_unique($result[$offer->category]);
    }


    $testList = [
        new ProductParams($offers),
        new Categories($offers)
    ];

    $testContaioner = new TestContainer($testList);


    foreach ($offers as $offer) {
        if (is_null($result[$offer->category])) {
            $result[$offer->category] = [];
        }
        $result[$offer->category] += array_keys($offer->params);
        $result[$offer->category] = array_unique($result[$offer->category]);
    }


    print_r($testContaioner->start());

//    print_r("Test");
//    print_r($result);
//    echo  json_encode($result,JSON_UNESCAPED_UNICODE);
//    foreach ($offers as $offer) {
//        foreach ($offer->params as $key => $value) {
//            $result[$offer->category][$key][] = $value;
//            $result[$offer->category][$key] = array_unique($result[$offer->category][$key]);
//        }
//    }
//    print_r($result);
}

test();

//
//function main(){
//    $config = new \Config\AppConfig(__DIR__."/config.json");
//
//    $db = new MysqlConnection($config);
//
//    $token = $config->get("token");
//    $query = new \WBApi\WBQuery($token);
//
//    $url = $config->get("url");
//    $parser = new \Parser\Parser($url);
//    $dict = [];
//    foreach ($db->getAllInfo() as $offer) {
//        $dict[$offer->id]=[
//            'barcode' => $offer->barcode,
//            'stock' => 0,
//        ];
//    }
//    foreach ($offers as $offer) {
//        $dict[$offer->id]['stock'] = $offer->outlet;
//    }
//    $warehouseId = $config->get("warehouseId");
//    foreach ($offers as $offer) {
//        $dict[$offer->id]['stock'] = $offer->outlet;
//        $dict[$offer->id]['warehouseId'] = $warehouseId;
//    }
//    foreach (array_chunk(array_values($dict), 1000) as $arStock) {
//        try {
//            $query->stocks($warehouseId,$arStock);
//        }
//        catch (\Exception $e) {
//            $log = date('Y-m-d H:i:s request') .' '.print_r($arStock, true). ' response:'.print_r(unserialize($e->getMessage()), true);
//            file_put_contents(__DIR__ . '/logs/log.txt', $log . PHP_EOL, FILE_APPEND);
//            continue;
//        }
//    }
//}
//
//main();


