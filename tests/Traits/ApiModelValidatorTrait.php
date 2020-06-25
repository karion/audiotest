<?php

declare(strict_types=1);

namespace Tests\Traits;

use LogicException;
use Tests\ApiModel\ApiModelInterface;

trait ApiModelValidatorTrait
{
    private $uuidPattern = '';

    private function responseAssertions(array $arrayResponse, array $expected = [], string $objectNamespace = null)
    {


        if ($objectNamespace !== null && class_exists($objectNamespace)) {
            /** @var ApiModelInterface $objectNamespace */
            foreach ($objectNamespace::getFields() as $field => $type) {
                $this->assertArrayHasKey(
                    $field,
                    $arrayResponse,
                    sprintf('Key `%s` does not exist in response', $field)
                );
                $this->validateType($arrayResponse, $field, $type);
            }
        } elseif (strpos($objectNamespace, '[]') === strlen($objectNamespace) - 2) { // arrays of types eg. string[]
            $type = substr($objectNamespace, 0, strlen($objectNamespace) - 2);
            $this->assertIsArray($arrayResponse);

            foreach ($arrayResponse as $item) {
                $this->responseAssertions($item, [], $type);
            }
        }

        foreach ($expected as $key => $value) {
            $this->assertArrayHasKey($key, $arrayResponse);
            $this->assertEquals($value, $arrayResponse[$key]);
        }
    }

    protected function validateType(array $arrayResponse, $field, string $type): void
    {
        $value = $arrayResponse[$field];

        if (null === $value || in_array(ApiModelInterface::NULL, explode('|', $type))) { // yes, null = string :)
            return;
        }

        if (class_exists($type) && !in_array($type, [ApiModelInterface::DATETIME, 'date'])) { // validate sub resource
            /** @var ApiModelInterface $modelNamespace */
            $modelNamespace = $type;
            foreach ($modelNamespace::getFields() as $field2 => $type) {
                $this->validateType($value, $field2, $type);
            }
        } elseif (strpos($type, '[]') === strlen($type) - 2) { // arrays of types eg. string[]
            $type = substr($type, 0, strlen($type) - 2);
            $this->assertIsArray($value);
            foreach ($value as $key => $item) {
                $this->validateType($value, $key, $type);
            }
        } elseif (ApiModelInterface::UUID === $type) {
            $this->assertTrue((bool)preg_match('/^([0-9a-fA-F]){8}-([0-9a-fA-F]){4}-([0-9a-fA-F]){4}-([0-9a-fA-F]){4}-([0-9a-fA-F]){12}$/', $value));
        } elseif (ApiModelInterface::DATETIME === $type) {
            $this->assertTrue(
                (bool)preg_match(
                    '/^20[0-9]{2}\-(0[0-9]|1[0-2])\-([0-2][0-9]|3[0-1])\T([0-1][0-9]|2[0-3])\:([0-5][0-9])\:([0-5][0-9])\+(0[0-9]|1[0-2])\:00$/',
                    $value
                )
            );
        } elseif (ApiModelInterface::STRING === $type) {
            $this->assertIsString($value);
        } elseif (ApiModelInterface::BOOLEAN === $type || 'bool' === $type) {
            $this->assertIsBool($value);
        } elseif (ApiModelInterface::INTEGER === $type || 'int' === $type) {
            $this->assertIsInt($value);
        } elseif (ApiModelInterface::ARRAY === $type) {
            $this->assertIsArray($value);
        } elseif (ApiModelInterface::FLOAT === $type) {
            $this->assertTrue(is_float($value) || is_int($value));
        } else {
            throw new LogicException(sprintf('Undefined type `%s`.', $type));
        }
    }
}