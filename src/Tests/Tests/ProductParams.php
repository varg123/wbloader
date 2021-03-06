<?php

namespace Tests\Tests;

use Tests\ITest;

class ProductParams implements ITest
{

    private $offers;

    public function __construct($offers)
    {
        $this->offers = $offers;
    }

    public function getName(): string
    {
        return 'Набор параметров у категорий';
    }

    public function test(): array
    {
        $result = [];
        $offers = $this->offers;
        $structParams = $this->structParams;
        $errors = [];
        foreach ($offers as $offer) {
            if (is_null($result[$offer->category])) {
                $result[$offer->category] = [];
            }
            $result[$offer->category] += array_keys($offer->params);
            $result[$offer->category] = array_unique($result[$offer->category]);
        }

        print_r($result);
        foreach ($result as $key => $item) {
//            print_r($structParams);
//            print_r($result);
            $difVal = array_diff($result[$key]?:[], $structParams[$key]?:[]);

//            if ($key=='Мужские часы') {
//                print_r($result[$key]);
//                print_r($structParams[$key]);
//                print_r($difVal);
//
//            }
            if ($difVal) {
                $errors[] = "у {$key} новый параметр(ы) ".implode(', ', $difVal);
            }
        }
        return $errors;
    }

    private $structParams = [
        "Настенные часы" => [
            "Код товара",
            "Механизм",
            "Материал корпуса",
            "Класс водозащиты",
            "Форма",
            "Цвет циферблата",
            "Оформление цифр",
            "Звук",
            "Гарантия",
            "Диаметр корпуса",
            "Комплектность"
        ],
        "Мужские часы" => [
            "Код товара",
            "Пол",
            "Механизм",
            "Стекло",
            "Материал браслета",
            "Материал корпуса",
            "Класс водозащиты",
            "Форма",
            "Цвет циферблата",
            "Цвет ремня/браслета",
            "Оформление цифр",
            "Свойства",
            "Гарантия",
            "Комплектность",
            "Диаметр корпуса",
            "Секундомер",
            "Таймеры",
            "Батарея"
        ],
        "Женские часы" => [
            "Код товара",
            "Пол",
            "Механизм",
            "Стекло",
            "Материал браслета",
            "Материал корпуса",
            "Класс водозащиты",
            "Форма",
            "Цвет циферблата",
            "Цвет ремня/браслета",
            "Оформление цифр",
            "Гарантия",
            "Комплектность",
            "Диаметр корпуса",
            "Календарь",
            "Секундомер",
            "Таймеры",
            "Описание"
        ],
        "будильники" => [
            "Код товара",
            "Класс водозащиты",
            "Оформление цифр",
            "Звук",
            "Гарантия",
            "Комплектность",
            "Диаметр корпуса",
            "Индикатор даты",
            "Подсветка",
            "Календарь",
            "Функции"
        ],
        "Детские часы" => [
            "Код товара",
            "Пол",
            "Механизм",
            "Стекло",
            "Материал браслета",
            "Материал корпуса",
            "Класс водозащиты",
            "Форма",
            "Цвет циферблата",
            "Цвет ремня/браслета",
            "Оформление цифр",
            "Гарантия",
            "Комплектность",
            "Диаметр корпуса",
            "Индикатор даты",
            "Календарь",
            "Секундомер",
            "Таймеры"
        ],
        "настольные часы" => [
            "Код товара",
            "Механизм",
            "Класс водозащиты",
            "Гарантия",
            "Диаметр корпуса",
            "Форма",
            "Цвет циферблата",
            "Оформление цифр",
            "Звук",
            "Комплектность"
        ],
        "ремешки" => [
            "Код товара",
            "Гарантия",
            "Комплектность",
            "Цвет ремня/браслета",
            "Длина ремешка",
            "Ширина ремешка",
            "Длина большей части",
            "Длина меньшей части без застежки",
            "Описание"
        ]
    ];

}