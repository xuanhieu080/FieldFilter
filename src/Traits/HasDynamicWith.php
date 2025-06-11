<?php

namespace FieldFilter\Traits;
use Illuminate\Support\Str;

trait HasDynamicWith
{
    public function scopeWithFields($query, ?string $fields)
    {
        if (!$fields) return $query;
        $with = collect(explode(',', $fields))
            ->map(fn($f) => trim($f))
            ->filter(fn($f) => Str::contains($f, '.'))
            ->map(fn($f) => explode('.', $f)[0])
            ->unique()
            ->values()
            ->toArray();
        return $query->with($with);
    }
}
