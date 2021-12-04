<?php


namespace Service\Fabric\Product;


use Service\DTO\Offer;
use Service\Fabric\Field\BaseField;
use Service\Fabric\Field\Fields\AddinField;
use Service\Fabric\Field\Fields\BrandField;
use Service\Fabric\Field\Fields\CountryField;
use Service\Fabric\Field\Fields\KeysField;
use Service\Fabric\Field\Fields\MaterialBraslField;
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
            new AddinField('Тнвэд', "9102990000"),
        ];

        $fields[] = new MultiAddinField('Комплектация', [
            'упаковка',
            'часы'
        ]);
        $fields[] = new MaterialBraslField( $offer->category);

        $fields[] = new SexField($offer->category);
//        $fields[] = new AddinField('Материал стекла', "в описании");

        $fields[] = new NomenclatureField($offer->articul, $offer->barcode, $offer->price, $offer->picture);
        $fields[] = new SupplierArticleNumberField($offer->articul2);


        switch ($offer->category) {
            case "Мужской ремень CLASSIC":
                $fields[] = new KeysField([
                    'наручные часы',
                    'мужские наручные часы',
                    'наручные часы omax'
                ]);
                break;
            case "Женский браслет":
            case "Женский ремень":
                $fields[] = new KeysField([
                    'женские наручные часы','наручные часы omax', 'наручные часы'
                ]);
                break;
            case "Мужской ремень CLASSIC с календарем":
            case "Мужской ремень PREMIUM":
            case "Мужской браслет":
                $fields[] = new KeysField([
                    'мужские наручные часы','наручные часы omax', 'наручные часы'
                ]);
                break;
            case "ЭЛИТНЫЕ часы OMAX":
                $fields[] = new KeysField([
                    'мужские наручные часы','женские наручные часы', 'унисекс'
                ]);
                break;
            case "OMAX СЕТ (в коробке мужская и женская модель)":
                $fields[] = new KeysField([
                    'женские наручные часы','мужские наручные часы', 'унисекс'
                ]);
                break;
        }
        $description = preg_replace('/[^а-яА-ЯёЁ0-9a-zA-Z@!?,.|\/:;\'"*&@#$№%\[\]{}()+\-$\s]/u', '', $offer->description);
        $fields[] = new AddinField('Описание', mb_substr($description,0,1000));
        return $fields;
    }

}