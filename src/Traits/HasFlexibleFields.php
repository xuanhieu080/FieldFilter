<?php

namespace FieldFilter\Traits;

use Illuminate\Support\Collection;

trait HasFlexibleFields
{
    protected function filterFields($model, array $requested, string $resourceClass): array
    {
        $config = config("fields.resources.{$resourceClass}", []);

        $strict = config('fields.strict');
        $fields = $config['fields'] ?? [];
        $rels = $config['relations'] ?? [];
        $res = [];

        foreach ($requested as $key => $nested) {
            if (is_array($nested) && method_exists($model, $key) && $model->relationLoaded($key)) {
                if ($strict && !in_array($key, $rels)) abort(400, "Relation {$key} not allowed");
                $r = $model->$key;
                $res[$key] = $r instanceof Collection
                    ? $r->map(fn($i)=> $this->filterFields($i, $nested, $resourceClass))->all()
                    : $this->filterFields($r, $nested, $resourceClass);
            } else {
                if (!array_key_exists($key, $model->getAttributes())) {
                    if ($strict) abort(400, "Field {$key} not exists");
                    continue;
                }
                if ($strict && $fields && !in_array($key, $fields)) abort(400, "Field {$key} not allowed");
                $res[$key] = $model->$key;
            }
        }
        
        return $res;
    }
}
