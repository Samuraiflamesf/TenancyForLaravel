<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateTenantUser implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Tenant $tenant) {}
    public function handle(): void
    {
        $this->tenant->run(function () {
            User::create([
                'name' => $this->tenant->name_user,
                'email' => $this->tenant->email,
                'cpf' => $this->tenant->cpf,
                'password' => $this->tenant->password,
            ]);
        });
    }
}