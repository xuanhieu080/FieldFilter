<?php

namespace FieldFilter\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use FieldFilter\Traits\HasFlexibleFields;
use FieldFilter\Support\FieldParser;

class FlexibleResource extends JsonResource
{
    use HasFlexibleFields;

    public function toArray($request)
    {
        $this->resourceClass = static::class;
        $fields = $request->query('fields', '');
        $parsed = FieldParser::parse($fields);
        return $this->filterFields($this->resource, $parsed);
    }
}
