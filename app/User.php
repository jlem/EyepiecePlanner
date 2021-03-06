<?php

namespace EPP;

use EPP\EyepieceSet\EyepieceSet;
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
        'name', 'email', 'password', 'pupil_size'
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

    public function eyepieceSets()
    {
        return $this->hasMany(EyepieceSet::class);
    }

    public function getID()
    {
        return $this->getKey();
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

    public function getPupilSize()
    {
        return $this->pupil_size;
    }

    public function getEyepieceSets()
    {
        return $this->eyepieceSets;
    }
}
