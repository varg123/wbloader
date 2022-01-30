<?php


namespace Service\Fabric\Product;


use Service\DTO\Offer;
use Service\Fabric\Field\BaseField;
use Service\Fabric\Field\Fields\AddinField;
use Service\Fabric\Field\Fields\BrandField;
use Service\Fabric\Field\Fields\CountryField;
use Service\Fabric\Field\Fields\KeysField;
use Service\Fabric\Field\Fields\MaterialGlassField;
use Service\Fabric\Field\Fields\MultiAddinField;
use Service\Fabric\Field\Fields\NomenclatureField;
use Service\Fabric\Field\Fields\ObjectField;
use Service\Fabric\Field\Fields\SupplierArticleNumberField;

class TableClock extends BaseProduct
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
            new ObjectField("Часы настольные"),
            new BrandField($offer->vendor),
            new CountryField($offer->vendor),
            new AddinField('Комплектация', "в описании"),
            new MaterialGlassField($offer->glass),
            new AddinField('Тнвэд', "9105990000"),
        ];

//        if($offer->materialBody) {
//            $fields[]= new AddinField('Материал корпуса', $offer->materialBody);
//        }
//        else {
//            $fields[]= new AddinField('Материал корпуса', "в описании");
//        }


        $fields[] = new NomenclatureField($offer->articul, $offer->barcode, $offer->price, $offer->picture,[
            $offer->colorBody,
            $offer->colorDial,
        ]);


        //необязательные

        $fields[] = new AddinField('Наименование', mb_substr($offer->name,0,100));

        if ((int)$offer->length) {
            $fields[] = new AddinField('Глубина упаковки', null, (int)$offer->length / 10);
        }

        if ((int)$offer->weight) {
            $fields[] = new AddinField('Ширина упаковки', null, (int)$offer->weight / 10);
        }

        if ((int)$offer->height) {
            $fields[] = new AddinField('Высота упаковки', null, (int)$offer->height / 10);
        }

        //todo: перезалить
        $fields[] = new SupplierArticleNumberField($offer->articul2);

        $fields[] = new KeysField($offer->vat);


        $options = [
            $offer->functions,
            $offer->battery,
            $offer->dateIndicator,
            $offer->illumination,
            $offer->calendar,
            $offer->timers,
            $offer->sound,
        ];
        $cleanOptions = [];
        foreach ($options as $option) {
            if ($option) {
                $cleanOptions = array_merge($cleanOptions, explode(' | ', $option));
            }
        }
        $fields[] = new MultiAddinField('Доп. опции интерьерных часов', $cleanOptions);

        $description = "";
//        $description = "{$offer->name}.\n ";
        foreach ($offer->params as $name => $value) {
            $description.="{$name}: $value.\n ";
        }
        $fields[] = new AddinField('Описание', $description);
        return $fields;
    }

}