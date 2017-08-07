<?php

namespace EPP\Transformers;

use EPP\Telescope;
use Illuminate\Support\Collection;

class TelescopeJSONTransformer
{
    public function toJson(Collection $collection)
    {
        return $collection->map(function (Telescope $telescope) {
            return [
                'id' => $telescope->getID(),
                'name' => str_replace('"', '\"', $telescope->getName()),
                'aperture' => $telescope->getAperture(),
                'focal_length' => $telescope->getFocalLength(),
                'max_eyepiece_size' => $telescope->getMaxEyepieceSize(),
                'is_custom' => false
            ];
        });
    }
}