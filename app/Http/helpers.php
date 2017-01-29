<?php

function isAdmin()
{
    if (!Auth::check()) {
        return false;
    }

    return Auth::user()->isAdmin();
}
