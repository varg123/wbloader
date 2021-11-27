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
    $config = new \Config\AppConfig("config.json");

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
    print_r($offer->price);
    foreach ($offers as $offer) {
        $dict[$offer->id]['price'] = (int)$offer->price;
    }

    $result = [];
    foreach ($dict as $item) {
        if ($item['nmId'] and $item['price']){
            $result[] = new \WBApi\DTO\Price($item);
        }
    }
    print_r($result);
    foreach ($result as $arPrice) {
        try {
            $res = $query->prices([$arPrice]);
            print_r($res);
        }
        catch ( \Exception $e) {
            print_r($e->getMessage());
        }
    }
}

main();


