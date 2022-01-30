<?php

namespace Service\Fabric\Field\Fields;

use Service\Fabric\Field\IField;
use WBApi\DTO\Addin;
use WBApi\DTO\Card;

class CountryField implements IField
{

    protected $value = null;

    public function __construct($vendor = null)
    {
        $this->value = $vendor;
    }

    /**
     * @param $card Card
     * @return Card
     */
    function applyField($card)
    {
        $value = $this->value;
        if ($this->countries[$value]) {
            $card->countryProduction = $this->countries[$value];
        }
        return $card;
    }

    protected $countries = [
        "Автопроставки" => "Россия",
        "CERTINA" => "Швейцария",
        "SLAZENGER" => "Китай",
        "ПИЛОТ" => "Китай",
        "CITIZEN" => "Япония",
        "ANNE KLEIN" => "Соединенные Штаты",
        "FESTINA" => "Испания",
        "CASIO |  EDIFICE" => "Япония",
        "NAUTICA" => "Соединенные Штаты",
        "ARDI" => "Беларусь",
        "SBP _ RC" => "Соединенные Штаты",
        "CASIO |  BABY-G" => "CASIO",
        "JACQUES LEMANS" => "Австрия",
        "LUMINOX" => "Соединенные Штаты",
        "LOWELL" => "Италия",
        "BOCCIA" => "Германия",
        "DKNY" => "Соединенные Штаты",
        "POWER" => "Китай",
        "CASIO |  PRO TREK" => "Япония",
        "CASIO |  SHEEN" => "Япония",
        "CASIO" => "Япония",
        "CANDINO" => "Швейцария",
        "SWISS MILITARY HANOW" => "Швейцария",
        "RHYTHM" => "Япония",
        "ELCANO" => "Корея, Республика",
        "CALVIN KLEIN" => "Соединенные Штаты",
        "ORIENT" => "Япония",
        "LEE COOPER" => "Соединенное Королевство",
        "LA MER" => "Корея, Республика",
        "INOX plus" => "Германия",
        "COVER" => "Швейцария",
        "STELLA" => "Корея, Республика",
        "Q_Q" => "Япония",
        "SINIX" => "Корея, Республика",
        "STAILER" => "Германия",
        "RAYMOND WEIL" => "Швейцария",
        "TIMBERLAND" => "Соединенные Штаты",
        "LA MINOR" => "Китай",
        "BALMAIN" => "Франция",
        "HERMLE" => "Германия",
        "TOMAS STERN" => "Германия",
        "CASIO |  VINTAGE" => "Япония",
        "DANIEL KLEIN" => "Турция",
        "TIMCO" => "Корея, Республика",
        "CASIO |  G-SHOCK" => "Япония",
        "B_S" => "Корея, Республика",
        "ATLANTIC" => "Швейцария",
        "PIERRE RICAUD" => "Германия",
        "ROMANSON" => "Корея, Республика",
        "SEIKO" => "Япония",
        "DIY CLOCK" => "Китай",
        "KAIROS" => "Корея, Республика",
        "ADRIATICA" => "Швейцария",
        "RODANIA" => "Швейцария",
        "BERING" => "Дания",
        "EPOS" => "Швейцария",
        "GEORGE KINI" => "Италия",
        "HOWARD MILLER" => "Соединенные Штаты",
        "AVIERE" => "Италия",
        "GREENWICH" => "Соединенное Королевство",
        "GUARDO" => "Италия",
        "LBS" => "Соединенное Королевство",
        "WORLD" => "Китай",
        "ТРОЙКА" => "Россия",
        "STEELS" => "Китай",
        "IRGACRAFT" => "Россия",
        "ACCURATE" => "Швейцария",
        "APEYRON" => "Китай",
        "APEYRON ELECTRICS" => "Китай",
        "APPELLA" => "Швейцария",
        "ATOMIC" => "Китай",
        "BEN SHERMAN" => "Соединенное Королевство",
        "ESSENCE" => "Корея, Республика",
        "FREELOOK" => "Франция",
        "FROGNER STATUS" => "Россия",
        "GRANCE" => "Россия",
        "MORGAN" => "Франция",
        "SKAGEN" => "Дания",
        "VST" => "Китай",
        "Wainer" => "Швейцария",
        "WENDOX" => "Соединенное Королевство",
        "ZIPPO" => "Соединенные Штаты",
        "ВОСТОК" => "Россия",
        "САТУРН" => "Россия",
        "УТЕС" => "Россия",
        "ФАБРИКА ВРЕМЕНИ" => "Россия",
        "Мила" => "Россия",
        "МИЛА" => "Россия",
        "НИКА" => "Россия",
        "QWILL" => "Россия",
        "ВЕСНА" => "Россия",
        "БРИГ" => "Россия",
        "СПЕКТР" => "Россия",
        "МИХАИЛ МОСКВИН" => "Россия",
        "HIRSCH" => "Австрия",
        "SUUNTO" => "Япония",
        "TIMEX" => "Соединенные Штаты",
        "MIRRON" => "Россия",
        "САЛЮТ" => "Россия",
        "NICOLE TIME" => "Россия",
        "СЛАВА" => "Россия",
        "МОЛНИЯ" => "Россия",
    ];
}