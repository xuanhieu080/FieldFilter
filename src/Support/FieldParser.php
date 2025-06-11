<?php

namespace FieldFilter\Support;

class FieldParser
{
    public static function parse(string $fields): array
    {
        return collect(explode(',', $fields))
            ->map('trim')
            ->filter()
            ->reduce(fn($carry, $f) => tap($carry, fn(&$c) => static::addNestedField($c, explode('.', $f))), []);
    }

    private static function addNestedField(array &$a, array $parts)
    {
        $k = array_shift($parts);
        if (!isset($a[$k])) $a[$k]=[];
        if ($parts) static::addNestedField($a[$k],$parts);
    }
}
