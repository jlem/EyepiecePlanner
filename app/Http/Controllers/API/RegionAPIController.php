<?php

namespace EPP\Http\Controllers\API;

use EPP\Http\APIResponse;
use EPP\Models\Region;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegionAPIController
{
    public function index()
    {
        return new APIResponse(Region::all()->toArray());
    }

    public function details($id)
    {
        return new APIResponse(Region::find($id));
    }
}