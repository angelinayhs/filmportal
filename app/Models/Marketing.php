<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Marketing extends Authenticatable
{
    use Notifiable;

    protected $guard = 'marketing';

    protected $fillable = [
        'name',
        'email',
        'password',
        'studio_id',
        'role',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}