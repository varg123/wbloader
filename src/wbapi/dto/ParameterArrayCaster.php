<?php


namespace WBApi\DTO;


use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\DataTransferObject;


class ParameterArrayCaster implements Caster
{
    public function cast(mixed $value): array
    {
        if (! is_array($value)) {
            throw new Exception("Can only cast arrays to Foo");
        }

        return array_map(
            fn (array $data) => new Parameter(...$data),
            $value
        );
    }
}