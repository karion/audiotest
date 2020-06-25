<?php

namespace Tests\ApiModel;

class ProductApiModel implements ApiModelInterface
{
    public static function getFields(): array
    {
        return [
            'id' => self::UUID,
            'name' => self::STRING,
            'price' => MoneyApiModel::class
        ];
    }
}