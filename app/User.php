<?php

namespace EPP;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function telescopes()
    {
        return $this->hasMany(Telescope::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return Collection
     */
    public function getTelescopes()
    {
        return $this->telescopes;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function isAdmin()
    {
        foreach($this->getRoles() as $role) {
            if ($role->isAdmin()) {
                return true;
            }
        }

        return false;
    }
}
