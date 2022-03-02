<?php


namespace Service\Fabric\Product;


use Service\DTO\Offer;
use Service\Fabric\Field\BaseField;
use Service\Fabric\Field\Fields\AddinField;
use Service\Fabric\Field\Fields\BrandField;
use Service\Fabric\Field\Fields\CountryField;
use Service\Fabric\Field\Fields\KeysField;
use Service\Fabric\Field\Fields\MaterialBraceletField;
use Service\Fabric\Field\Fields\MaterialGlassField;
use Service\Fabric\Field\Fields\NomenclatureField;
use Service\Fabric\Field\Fields\ObjectField;
use Service\Fabric\Field\Fields\SexField;
use Service\Fabric\Field\Fields\SupplierArticleNumberField;

class BraceletsWatches extends BaseProduct
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
            new ObjectField("Браслеты для часов"),
            new BrandField($offer->vendor),
            new CountryField($offer->vendor),
            new AddinField('Тнвэд', "9113900009"),
            new SexField($offer->sex),
        ];


        $fields[] = new MaterialBraceletField($offer->materialBracelet);

        $fields[] = new NomenclatureField($offer->articul, $offer->barcode, $offer->price, $offer->picture, [
            $offer->colorBracelet
        ], $offer->widthStrap);


        $fields[] = new SupplierArticleNumberField($offer->articul2);
        $fields[] = new AddinField('Наименование', mb_substr($offer->name,0,100));

        $fields[] = new AddinField('Глубина упаковки', null, 12);
        $fields[] = new AddinField('Ширина упаковки', null, 0.5);
        $fields[] = new AddinField('Высота упаковки', null, 5);
        if((int)$offer->widthStrap) {
            $fields[] = new AddinField('Ширина ремешка', null, (int)$offer->widthStrap/10);
        }
        $fields[] = new AddinField('Комплектация', 'упаковка, ремешок');




        $description = "";
        foreach ($offer->params as $name => $value) {
            $description .= "{$name}: $value.\n ";
        }
        $fields[] = new AddinField('Описание', $description);
        return $fields;
    }

}