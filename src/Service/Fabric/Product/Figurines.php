<?php


namespace Service\Fabric\Product;


use Service\DTO\Offer;
use Service\Fabric\Field\BaseField;
use Service\Fabric\Field\Fields\AddinField;
use Service\Fabric\Field\Fields\BrandField;
use Service\Fabric\Field\Fields\CountryField;
use Service\Fabric\Field\Fields\KeysField;
use Service\Fabric\Field\Fields\MaterialGlassField;
use Service\Fabric\Field\Fields\NomenclatureField;
use Service\Fabric\Field\Fields\ObjectField;
use Service\Fabric\Field\Fields\SexField;
use Service\Fabric\Field\Fields\SupplierArticleNumberField;

class Figurines extends BaseProduct
{

    protected $offer = null;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function getFields()
    {
        /**
         * @var $offer Offer
         */
        $offer = $this->offer;

        $fields = [
            new ObjectField("Статуэтки"),
            new BrandField($offer->vendor),
            new CountryField($offer->vendor),
            new AddinField('Тнвэд', "6810990000"),
            new AddinField('Материал изделия', "в описании"),
        ];

        if ($offer->guration) {
            $fields[] = new AddinField('Комплектация',  $offer->guration);
        }
        else {
            $fields[] = new AddinField('Комплектация',  'в описании');
        }


        $fields[] = new NomenclatureField($offer->articul, $offer->barcode, $offer->price, $offer->picture);
        $fields[] = new SupplierArticleNumberField($offer->articul2);


        //необязательные

        $fields[] = new AddinField('Наименование', mb_substr($offer->name,0,100));
        if ((int)$offer->length) {
            $fields[] = new AddinField('Глубина упаковки', null, (int)$offer->length / 10);
        }
        if ((int)$offer->width) {
            $fields[] = new AddinField('Ширина упаковки', null, (int)$offer->width / 10);
        }

        if ((int)$offer->height) {
            $fields[] = new AddinField('Высота упаковки', null, (int)$offer->height / 10);
        }


        $fields[] = new KeysField($offer->vat);


        $description = "";
//        $description = "{$offer->name}.\n ";
        foreach ($offer->params as $name => $value) {
            $description.="{$name}: $value.\n ";
        }
        $fields[] = new AddinField('Описание', $description);
        return $fields;
    }

}