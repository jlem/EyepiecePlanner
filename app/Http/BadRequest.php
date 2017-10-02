<?php

namespace EPP\Http;

class BadRequest extends APIResponse
{
    public function __construct($errors) {
        parent::__construct(null, $errors, 400);
    }
}