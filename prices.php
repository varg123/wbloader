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

    $dict = [];
    /**
     * @var $offer \DB\Info
     */
    foreach ($db->getAllInfo() as $offer) {
        $dict[$offer->id]=[
            'nmId' => (string)$offer->nmId,
//            'price' => $offer->price,
        ];
    }
    /**
     * @var $offer \Service\DTO\Offer
     */
    foreach ($offers as $offer) {
        $dict[$offer->id]['price'] = (int)$offer->price;
    }

    $result = [];
    foreach ($dict as $item) {
        if ($item['nmId'] and $item['price']){
            $result[] = new \WBApi\DTO\Price($item);
        }
    }
    foreach ($result as $arPrice) {
        try {
            $res = $query->prices([$arPrice]);
        }
        catch ( \Exception $e) {
            $log = date('Y-m-d H:i:s request') .' '.print_r($arPrice, true). ' response:'.print_r(unserialize($e->getMessage()), true);
            file_put_contents(__DIR__ . '/logs/log.txt', $log . PHP_EOL, FILE_APPEND);
            continue;
        }
    }
}

main();


