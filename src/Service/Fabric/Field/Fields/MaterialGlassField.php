<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class MaterialGlassField implements IField
{

    protected $value = null;

    public function __construct($glass)
    {
        $this->value = $glass;
    }

    /**
     * @param $card Card
     * @return Card
     */
    function applyField($card)
    {
        $value = $this->value;
        if ($this->material[$value]) {
            $card->addin[] = new Addin([
                'type' => 'Материал стекла',
                'params' => [
                    [
                        'value' => $this->material[$value]
                    ]
                ]
            ]);
        }
        else {
            $card->addin[] = new Addin([
                'type' => 'Материал стекла',
                'params' => [
                    [
                        'value' => 'стекло'
                    ]
                ]
            ]);
        }
        return $card;
    }

    protected $material = [
        "минеральное" => "минеральное стекло",
        "сапфировое стекло с антибликовым покрытием" => "сапфир",
        "минеральное повышенной прочности" => "минеральное стекло",
        "без стекла" => "без стекла",
        "акриловое" => "Акриловое стекло",
        "минеральное с сапфировым напылением" => "минеральное стекло",
        "закаленное минеральное" => "минеральное стекло",
        "стеклопластик" => "пластик, стекло",
        "есть стекло" => "стекло",
        "сапфировое" => "сапфир"
    ];
}