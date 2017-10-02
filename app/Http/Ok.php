<?php

namespace EPP\Http;

class Ok extends APIResponse
{
    public function __construct($data) {
        parent::__construct($data);
    }
}