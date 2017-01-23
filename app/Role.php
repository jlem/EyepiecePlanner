<?php

namespace EPP;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }
}
