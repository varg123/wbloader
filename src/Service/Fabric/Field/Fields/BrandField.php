<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class BrandField implements IField
{

    protected $value = null;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * @param $card Card
     * @return Card
     */
    function applyField($card)
    {
        $value = $this->value;
        if ($this->barnds[$value]) {
            $card->addin[] = new Addin([
                'type' => 'Бренд',
                'params' => [
                    [
                        'value' => $this->barnds[$value]
                    ]
                ]
            ]);
        }
        return $card;
    }

    protected $barnds = [
        "нет бренда" => "нет бренда",
        "CERTINA" => "CERTINA",
        "ПИЛОТ" => "ПИЛОТ",
        "SLAZENGER" => "SLAZENGER",
        "ANNE KLEIN" => "ANNE KLEIN",
        "CITIZEN" => "CITIZEN",
        "FESTINA" => "Festina",
        "СЛАВА" => "Слава",
        "CASIO |  EDIFICE" => "CASIO",
        "NAUTICA" => "Nautica",
        "БРИГ" => "БРИГ",
        "QWILL" => "QWILL",
        "ARDI" => "ARDI",
        "SBP _ RC" => "santa barbara polo & racquet club",
        "CASIO |  BABY-G" => "CASIO",
        "JACQUES LEMANS" => "Jacques Lemans",
        "LUMINOX" => "Luminox",
        "LOWELL" => "Lowell Press",
        "BOCCIA" => "Boccia Titanium",
        "DKNY" => "DKNY",
        "POWER" => "POWER",
        "CASIO |  PRO TREK" => "CASIO",
        "CASIO |  SHEEN" => "CASIO",
        "CASIO" => "CASIO",
        "CANDINO" => "CANDINO",
        "SWISS MILITARY HANOW" => "Swiss Military Hanowa",
        "RHYTHM" => "RHYTHM",
        "MIRRON" => "Mirron",
        "ELCANO" => "Elcano",
        "CALVIN KLEIN" => "CALVIN KLAIN",
        "ORIENT" => "Orient",
        "LEE COOPER" => "LEE COOPER",
        "LA MER" => "LA MER",
        "СПЕКТР" => "Спектр",
        "INOX plus" => "INOX",
        "COVER" => "Cover",
        "ВЕСНА" => "Весна часы",
        "STELLA" => "Stella",
        "НИКА" => "Ника",
        "Q_Q" => "Q&Q",
        "SINIX" => "Sinix",
        "STAILER" => "STAILER",
        "NICOLE TIME" => "NICOLE TIME",
        "RAYMOND WEIL" => "RAYMOND WEIL",
        "TIMBERLAND" => "TIMBERLAND",
        "LA MINOR" => "La Minor",
        "BALMAIN" => "BALMAIN",
        "HERMLE" => "HERMLE",
        "TOMAS STERN" => "Tomas Stern",
        "САЛЮТ" => "Салют",
        "CASIO |  VINTAGE" => "CASIO",
        "DANIEL KLEIN" => "DANIEL KLEIN",
        "TIMCO" => "TIMCO",
        "CASIO |  G-SHOCK" => "CASIO",
        "B_S" => "B&S",
        "ATLANTIC" => "ATLANTIC",
        "PIERRE RICAUD" => "PIERRE RICAUD",
        "ROMANSON" => "Romanson",
        "МИХАИЛ МОСКВИН" => "Михаил Москвин",
        "SEIKO" => "Seiko",
        "DIY CLOCK" => "DIY Clock",
        "KAIROS" => "Kairos",
        "ADRIATICA" => "Adriatica",
        "RODANIA" => "RODANIA",
        "BERING" => "Bering",
        "EPOS" => "Epos",
        "СУВЕНИРЫ" => "Сувенир",
        "GEORGE KINI" => "GEORGE KINI",
        "HOWARD MILLER" => "HOWARD MILLER",
        "AVIERE" => "AVIERE",
        "GREENWICH" => "Greenwich",
        "GUARDO" => "GUARDO",
        "LBS" => "LBS",
        "WORLD" => "WORLD",
        "ТРОЙКА" => "ТРОЙКА",
        "STEELS" => "STEELS",
        "IRGACRAFT" => "IRGACRAFT",
        "ACCURATE" => "ACCURATE",
        "APEYRON" => "APEYRON",
        "APEYRON ELECTRICS" => "APEYRON ELECTRICS",
        "APPELLA" => "APPELLA",
        "ATOMIC" => "ATOMIC",
        "BEN SHERMAN" => "BEN SHERMAN",
        "ESSENCE" => "ESSENCE",
        "FREELOOK" => "FREELOOK",
        "FROGNER STATUS" => "FROGNER STATUS",
        "GRANCE" => "GRANCE",
        "MORGAN" => "MORGAN",
        "SKAGEN" => "SKAGEN",
        "VST" => "VST",
        "Wainer" => "Wainer",
        "WENDOX" => "WENDOX",
        "ZIPPO" => "Zippo",
        "ВОСТОК" => "ВОСТОК",
        "САТУРН" => "САТУРН",
        "УТЕС" => "УТЕС",
        "ФАБРИКА ВРЕМЕНИ" => "ФАБРИКА ВРЕМЕНИ",
        "Мила" => "Мила",
        "МИЛА" => "МИЛА",
        "HIRSCH" => "HIRSCH",
        "TIMEX" => "TIMEX",
        "SUUNTO" => "SUUNTO Watch",
        "МОЛНИЯ" => "МОЛНИЯ",
    ];
}