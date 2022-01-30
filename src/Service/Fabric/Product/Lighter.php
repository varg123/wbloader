<?php


namespace Service\Fabric\Product;


use Service\DTO\Offer;
use Service\Fabric\Field\Fields\AddinField;
use Service\Fabric\Field\Fields\BrandField;
use Service\Fabric\Field\Fields\CountryField;
use Service\Fabric\Field\Fields\KeysField;
use Service\Fabric\Field\Fields\NomenclatureField;
use Service\Fabric\Field\Fields\ObjectField;
use Service\Fabric\Field\Fields\SupplierArticleNumberField;

class Lighter extends BaseProduct
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
            new ObjectField("Зажигалки бензиновые 18+"),
            new BrandField($offer->vendor),
            new CountryField($offer->vendor),
            new AddinField('Комплектация',  'упаковка, зажигалка')
        ];



        $fields[] = new NomenclatureField($offer->articul, $offer->barcode, $offer->price, $offer->picture);
        $fields[] = new SupplierArticleNumberField($offer->articul2);


        //необязательные

//        $fields[] = new AddinField('Наименование', mb_substr($offer->name,0,100));
//        if ((int)$offer->length) {
//            $fields[] = new AddinField('Глубина упаковки', null, (int)$offer->length / 10);
//        }
//        if ((int)$offer->width) {
//            $fields[] = new AddinField('Ширина упаковки', null, (int)$offer->width / 10);
//        }
//
//        if ((int)$offer->height) {
//            $fields[] = new AddinField('Высота упаковки', null, (int)$offer->height / 10);
//        }




        $description = "";
//        $description = "{$offer->name}.\n ";
        foreach ($offer->params as $name => $value) {
            if ($name=='Комплектность') $value='упаковка, зажигалка';
            $description.="{$name}: $value.\n ";
        }
        $fields[] = new AddinField('Описание', $description);
        return $fields;
    }

}