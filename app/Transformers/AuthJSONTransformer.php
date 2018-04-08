<?php

namespace EPP\Transformers;

use EPP\User;

class AuthJSONTransformer
{
    public function toJson(User $auth) {
        $isAdmin = $auth->isAdmin();
        $isAuthenticated = !is_null($auth->name);
        $userName = $auth->name;

        return json_encode(compact('isAuthenticated', 'userName', 'isAdmin'));
    }
}