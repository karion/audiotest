<?php

namespace Tests\ApiModel;

class CartApiModel implements ApiModelInterface
{
    public static function getFields(): array
    {
        return [
            'id' => self::UUID,
            'user' => UserApiModel::class,
            'products' => ProductApiModel::class.'[]'
        ];
    }
}