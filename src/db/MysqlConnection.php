<?php


namespace DB;


class MysqlConnection
{

    private $connection = null;

    public function __construct($config)
    {
        $host = $config->get("dbhost");
        $login = $config->get("dblogin");
        $pass = $config->get("dbpass");
        $dbname = $config->get("dbname");
        $this->connection = new \mysqli(
            $host,
            $login,
            $pass,
            $dbname
        );
        if ($this->connection->connect_error) {
            throw new \Exception("Ошибка подключения к бд");
        }
    }

    public function getInfo($id)
    {
        $sql = "SELECT * FROM products WHERE id={$id}";
        $res = $this->connection->query($sql);
        $res = $res->fetch_assoc();
        if ($res) {
            return new Info($res);
        }
        return false;
    }

    /**
     * @param $info Info
     */
    public function setInfo($info)
    {
        if ($this->getInfo($info->id)) {
            $price = $info->price ? (int)$info->price : "NULL";
            $nmId = $info->nmId ? (int)$info->nmId : "NULL";
            $articul = $info->articul ? '"'.$info->articul.'"' : "NULL";
            $outlet = $info->outlet ? (int)$info->outlet : "NULL";
            $hash = $info->hash ? '"'.$info->hash.'"' : "NULL";
            $lastError = $info->lastError ? '"'.$info->lastError.'"' : "NULL";
            $lastErrorDate = $info->lastErrorDate ? '"'.$info->lastErrorDate.'"' : "NULL";
            $barcode = $info->barcode ? '"'.$info->barcode.'"' : "NULL";
            $sql = "Update products set  price={$price},  
                    nmId={$nmId}, 
                    articul={$articul}, 
                    outlet={$outlet} , 
                    hash={$hash}, 
                    lastError={$lastError}, 
                    lastErrorDate={$lastErrorDate},
                    barcode={$barcode}
                    where id={$info->id}";
        } else {
            $price = $info->price ? (int)$info->price : "NULL";
            $nmId = $info->nmId ? (int)$info->nmId : "NULL";
            $articul = $info->articul ? '"'.$info->articul.'"' : "NULL";
            $outlet = $info->outlet ? (int)$info->outlet : "NULL";
            $hash = $info->hash ? '"'.$info->hash.'"' : "NULL";
            $lastError = $info->lastError ? '"'.$info->lastError.'"' : "NULL";
            $lastErrorDate = $info->lastErrorDate ? '"'.$info->lastErrorDate.'"' : "NULL";
            $barcode = $info->barcode ? '"'.$info->barcode.'"' : "NULL";
            $sql = "INSERT INTO products SET id={$info->id},  nmId={$nmId},   price={$price},  
                    articul={$articul}, 
                    outlet={$outlet} , 
                    hash={$hash}, 
                    lastError={$lastError}, 
                    barcode={$barcode}, 
                    lastErrorDate={$lastErrorDate} ";
        }
        $result = $this->connection->query($sql);
        if ($result == false) {
            throw new \Exception("Ошибка запроса");
        }
    }
}