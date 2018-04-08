<?php

namespace EPP\Transformers;

use EPP\User;

class AuthJSONTransformer
{
    public function toJson(User $auth) {
        $isAdmin = $auth ? $auth->isAdmin() : false;
        $isAuthenticated = !is_null($auth);
        $userName = $auth ? $auth->name : null;

        return json_encode(compact('isAuthenticated', 'userName', 'isAdmin'));
    }
}