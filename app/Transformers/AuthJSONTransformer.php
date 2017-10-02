<?php

namespace EPP\Transformers;

class AuthJSONTransformer
{
    public function toJson($auth) {
        $isAuthenticated = !is_null($auth);
        $userName = $auth ? $auth->name : null;

        return json_encode(compact('isAuthenticated', 'userName'));
    }
}