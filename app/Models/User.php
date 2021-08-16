<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAdminEmails()
    {
        $user = (new static)::all();

        return $user->filter(function ($user) {
            return $user->isAn('Admin');
        })->pluck('email')->toArray();
    }

    public static function getUserEmails()
    {
        $user = (new static)::all();

        return $user->filter(function ($user) {
            return $user->isAn('Admin');
        })->pluck('email')->toArray();
    }
}