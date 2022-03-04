<?php


namespace Service\Fabric\Product;


use Service\DTO\Offer;
use Service\Fabric\Field\BaseField;
use Service\Fabric\Field\Fields\AddinField;
use Service\Fabric\Field\Fields\AdditionalField;
use Service\Fabric\Field\Fields\BrandField;
use Service\Fabric\Field\Fields\CountryField;
use Service\Fabric\Field\Fields\FormField;
use Service\Fabric\Field\Fields\KeysField;
use Service\Fabric\Field\Fields\MaterialBraceletWatchField;
use Service\Fabric\Field\Fields\MaterialGlassField;
use Service\Fabric\Field\Fields\MechanismField;
use Service\Fabric\Field\Fields\MultiAddinField;
use Service\Fabric\Field\Fields\NomenclatureField;
use Service\Fabric\Field\Fields\ObjectField;
use Service\Fabric\Field\Fields\SexField;
use Service\Fabric\Field\Fields\SupplierArticleNumberField;
use Service\Fabric\Field\Fields\TypeGlassField;

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

        $fields[] = new SexField($offer->sex);
        if ($offer->guration) {
            $fields[] = new AddinField('Комплектация',  $offer->guration);
        }
        else {
            $fields[] = new AddinField('Комплектация',  'в описании');
        }



        //необязательные
        $fields[] = new AddinField('Наименование', mb_substr($offer->name,0,100));
        $fields[] = new NomenclatureField($offer->articul, $offer->barcode, $offer->price, $offer->picture, [
            $offer->colorBody,
            $offer->colorDial,
            $offer->colorBracelet,
        ]);
        $fields[] = new SupplierArticleNumberField($offer->articul2);

        if($offer->glass) {
//            $fields[] = new TypeGlassField($offer->glass);
        }


        $fields[] = new AddinField('Глубина упаковки', null, 9);
        $fields[] = new AddinField('Ширина упаковки', null, 10);
        $fields[] = new AddinField('Высота упаковки', null, 10);


        if ((int)$offer->width) {
            $fields[] = new AddinField('Диаметр корпуса', null, (int)$offer->width/10);
        }
        if ((int)$offer->height) {
            $fields[] = new AddinField('Толщина корпуса', null, (int)$offer->height/10);
        }
        if ((int)$offer->length) {
            $fields[] = new AddinField('Ширина циферблата', null, (int)$offer->length/10);
        }

        if ($offer->materialBracelet) {
            $fields[] = new MaterialBraceletWatchField( $offer->materialBracelet);
        }
        $fields[] = new AddinField('Модель', $offer->kod);
//        print_r($fields);
//

//        $fields[] = new MechanismField($offer->mechanism);

        if ($offer->guarantee) {
            $fields[] = new AddinField('Гарантийный срок',  $offer->guarantee);
        }

        if ($offer->protectionClass) {
            if ($offer->protectionClass=='неводозащищенные')  {
                $fields[] = new AddinField('Класс водонепроницаемости',  $offer->protectionClass);
            }
        }

        $fields[] = new FormField($offer->form);
        $fields[] = new AddinField('Хрупкость', 'Хрупкое,аккуратно');
        if ($offer->colorDial and isset(NomenclatureField::$colorsDict[$offer->colorDial])) {
            $fields[] = new AddinField('Цвет циферблата',  NomenclatureField::$colorsDict[$offer->colorDial]);
        }




        $description = "";
        foreach ($offer->params as $name => $value) {
            $description.="{$name}: $value.\n ";
        }
        $fields[] = new AddinField('Описание', $description);
        return $fields;
    }

}