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
use Service\Fabric\Field\Fields\SexField;
use Service\Fabric\Field\Fields\SupplierArticleNumberField;

class WristWatches extends BaseProduct
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
            new ObjectField("Часы наручные"),
            new BrandField($offer->vendor),
            new CountryField($offer->vendor),
            new MaterialGlassField($offer->glass),
            new AddinField('Тнвэд', "9102990000"),
        ];

        if ($offer->guration) {
            $fields[] = new AddinField('Комплектация',  $offer->guration);
        }
        else {
            $fields[] = new AddinField('Комплектация',  'в описании');
        }
//
        if ($offer->materialBracelet) {
//            $fields[] = new AddinField('Материал браслета',  $offer->materialBracelet);
        } else {
//            $fields[] = new AddinField('Материал браслета', 'в описании');
        }
        $fields[] = new SexField($offer->sex);



        $fields[] = new NomenclatureField($offer->articul, $offer->barcode, $offer->price, $offer->picture, [
            $offer->colorBody,
            $offer->colorDial,
            $offer->colorBracelet,
        ]);


        //необязательные

        $fields[] = new AddinField('Наименование', mb_substr($offer->name,0,100));
        if ((int)$offer->length) {
            $fields[] = new AddinField('Глубина упаковки', null, (int)$offer->length / 10);
        }
//
        if ((int)$offer->width) {
            $fields[] = new AddinField('Ширина упаковки', null, (int)$offer->width / 10);
        }
//
        if ((int)$offer->height) {
            $fields[] = new AddinField('Высота упаковки', null, (int)$offer->height / 10);
        }
//
        $fields[] = new SupplierArticleNumberField($offer->articul2);
//
        if ($offer->mechanism) {
            if ($offer->mechanism=='электронный') {
                $offer->mechanism='Электронный кварцевый';
            }
            if ($offer->mechanism=='механический') {
                $offer->mechanism='механические';
            }

            if ($offer->mechanism=='кварцевый') {
                $offer->mechanism='Кварцевый';
            }
            $fields[] = new AddinField('Механизм часов',  $offer->mechanism);
        }
        if ($offer->guarantee) {
            $fields[] = new AddinField('Гарантийный срок',  $offer->guarantee);
        }
        if ($offer->protectionClass) {
            if ($offer->protectionClass='неводозащищенные')  {
                $offer->protectionClass='';
            }
            $fields[] = new AddinField('Класс водонепроницаемости',  $offer->protectionClass);
        }
//        if ($offer->mechanism) {
//            $fields[] = new AddinField('Механизм часов',  $offer->mechanism);
//        }
        if ($offer->form) {
//            $fields[] = new AddinField('Форма корпуса',  $offer->form);
        }
        if ($offer->colorDial and isset(NomenclatureField::$colorsDict[$offer->colorDial])) {
            $fields[] = new AddinField('Цвет циферблата',  NomenclatureField::$colorsDict[$offer->colorDial]);
        }


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
//        $fields[] = new MultiAddinField('Особенности часов', $cleanOptions);


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