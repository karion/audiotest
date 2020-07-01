<?php

declare(strict_types=1);

namespace Tests\ApiModel;

interface ApiModelInterface
{
    const STRING = 'string';
    const BOOLEAN = 'boolean';
    const INTEGER = 'integer';
    const ARRAY = 'array';
    const FLOAT = 'float';
    const DATETIME = 'datetime';
    const UUID = 'uuid';
    const NULL = 'null';

    static function getFields(): array;
}