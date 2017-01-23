<?php

use EPP\Guest;

function isAdmin()
{
    if (!Auth::check()) {
        return false;
    }

    return Auth::user()->isAdmin();
}

/**
 * Always returns a user object, even if it's a Guest null object
 * @return HasTelescopes
 */
function user()
{
    return Auth::check() ? Auth::user() : App::make(Guest::class);
}


function append($value, $toAppend)
{
    $toAppend = empty($value) ? '' : $toAppend;

    return $value . $toAppend;
}