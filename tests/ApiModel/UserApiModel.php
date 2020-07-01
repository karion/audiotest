<?php

namespace Tests\ApiModel;

class UserApiModel implements ApiModelInterface
{
    public static function getFields(): array
    {
        return [
            'id' => self::UUID,
            'email' => self::STRING
        ];
    }
}