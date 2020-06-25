<?php


namespace Tests\ApiModel;


class MoneyApiModel implements ApiModelInterface
{

    public static function getFields(): array
    {
        return [
            'cents' => self::INTEGER,
            'currency' => self::STRING
        ];
    }
}