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
    $content = json_decode(file_get_contents('products.json'), true);
    $config = new \Config\AppConfig("config.json");
    $db = new MysqlConnection($config);
    foreach ($content as $key => $value) {

        $db->setInfo(new \DB\Info([
            'id' => $key,
            'barcode' => $value['barcode'],
        ]));
    }
}

main();


