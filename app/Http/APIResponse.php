<?php

namespace EPP\Http;

use Illuminate\Http\JsonResponse;

class APIResponse extends JsonResponse
{
    public function __construct($data, array $errors = [], $status = 200, array $headers = [], $options = 0)
    {
        if (is_null($data)) {
            $status = 404;
        }

        $body = new \stdClass();
        $body->status = $status;
        $body->data = $data;
        $body->errors = $errors;

        parent::__construct($body, $status, $headers, $options);
    }
}