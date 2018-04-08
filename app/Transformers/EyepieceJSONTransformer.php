<?php

namespace EPP\Transformers;

use Illuminate\Support\Collection;

class EyepieceJSONTransformer
{
    public function toJson(Collection $eyepieces)
    {
        return str_replace('")', '&quot;)', $eyepieces->toJson());
    }
}