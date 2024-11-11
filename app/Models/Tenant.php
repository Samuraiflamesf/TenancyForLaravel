<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'name_user',
            'cpf',
            'email',
            'password',
        ];
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = Hash::make($value);
    }
}
