<?php
declare(strict_types=1);

namespace App\DTO;

use JsonSerializable;

abstract class AbstractJson implements JsonSerializable
{
    protected array $attributes = [];
    abstract public function toJsonArray(): void;

    public function setup (array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function jsonSerialize(): array
    {
        $data = [];
        foreach ($this->attributes as $key => $attribute) {
            if (!empty($attribute)) {
                if ($attribute instanceof AbstractJson) {
                    $attribute->toJsonArray();
                }
                $data[$key] = $attribute;
            }
        }
        return $data;
    }
}