<?php

use DB\MysqlConnection;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
function myAutoLoader(string $className)
{
    require_once __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';
}

spl_autoload_register('myAutoLoader');
error_reporting(E_ERROR | E_PARSE);




function main(){
    $config = new \Config\AppConfig(__DIR__."/config.json");

    $db = new MysqlConnection($config);

    $token = $config->get("token");
    $query = new \WBApi\WBQuery($token);

    $url = $config->get("url");
    $parser = new \Parser\Parser($url);
    $offers = $parser->getData();
    /**
     * @var $offer \Service\DTO\Offer
     */
    $dict = [];
    foreach ($db->getAllInfo() as $offer) {
        $dict[$offer->id]=[
            'barcode' => $offer->barcode,
            'stock' => 0,
        ];
    }
    foreach ($offers as $offer) {
        $dict[$offer->id]['stock'] = $offer->outlet;
    }
    $warehouseId = $config->get("warehouseId");
    foreach ($offers as $offer) {
        $dict[$offer->id]['stock'] = $offer->outlet;
        $dict[$offer->id]['warehouseId'] = $warehouseId;
    }
    foreach (array_chunk(array_values($dict), 1000) as $arStock) {
        try {
            $query->stocks($warehouseId,$arStock);
        }
        catch (\Exception $e) {
            $log = date('Y-m-d H:i:s request') .' '.print_r($arStock, true). ' response:'.print_r(unserialize($e->getMessage()), true);
            file_put_contents(__DIR__ . '/logs/log.txt', $log . PHP_EOL, FILE_APPEND);
            continue;
        }
    }
}

main();


