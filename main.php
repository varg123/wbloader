<?php

use DB\MysqlConnection;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
function myAutoLoader(string $className)
{
    require_once __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';
}

spl_autoload_register('myAutoLoader');
error_reporting(E_ERROR | E_PARSE);

/**
 * @param $query \WBApi\WBQuery
 * @param $offer
 * @return bool|mixed|\Service\Fabric\Product\NullProduct|\WBApi\DTO\Card|null
 * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
 */
function cardAction($query, $offer)
{
    $card = null;
    if (!$card and $offer->barcode) {
        $find = new \WBApi\DTO\Find([
            'column' => "nomenclatures.variations.barcode",
            'search' => $offer->barcode
        ]);
        $card = $query->cardList([$find])[0];

    }

    if (!$card and $offer->articul) {
        $find = new \WBApi\DTO\Find([
            'column' => "nomenclatures.vendorCode",
            'search' => $offer->articul
        ]);
        $card = $query->cardList([$find])[0];
    }
    if ($card) {
        $card = \Service\Fabric\ProductFabric::updateProduct($card, $offer);
        print_r(" update ");
        $query->cardUpdate($card);
        return $card;
    }

    print_r(" create ");
    $card = \Service\Fabric\ProductFabric::createProduct($offer);
    $query->cardCreate($card);
    return $card;
}


function main()
{
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
    foreach ($offers as $offer) {
        try {
            $offerInfo = $db->getInfo($offer->id);
            if (!$offerInfo) {
                $offerInfo = new \DB\Info();
                $offerInfo->id = $offer->id;
                $offerInfo->articul = $offer->articul;
                $barcode = $query->getBarcodes()[0];
                $offerInfo->barcode = $barcode;
                $offer->barcode = $barcode;
            } else {
                $offerInfo->articul = $offer->articul;
                $offer->barcode = $offerInfo->barcode;
            }

//            $hash = crc32(serialize($offer));
//            if ($offerInfo->hash == $hash and $offerInfo->lastError=='NULL' and $offerInfo->nmId) {
//                echo "Нет изменений";
//                continue;
//            } else {
//                $offerInfo->hash = $hash;
//            }

            print_r($offer->articul);
            echo " ";

            $card = cardAction($query, $offer);


            if ($card->nomenclatures[0]->nmId) {
                $offerInfo->nmId = $card->nomenclatures[0]->nmId;
            }

            if ($card->nomenclatures[0]->variations[0]->barcodes[0]) {
                $offerInfo->barcode = $card->nomenclatures[0]->variations[0]->barcodes[0];
            }
            $offerInfo->lastError = '';
            $db->setInfo($offerInfo);
        } catch (\Exception $e) {
            $log = date('Y-m-d H:i:s request') .' '.print_r($offer, true). ' response:'.print_r($e->getMessage(), true);
            file_put_contents(__DIR__ . '/logs/log.txt', $log . PHP_EOL, FILE_APPEND);
            $offerInfo->lastError = $e->getMessage();
            $db->setInfo($offerInfo);
            continue;
        }
    }
}

main();


