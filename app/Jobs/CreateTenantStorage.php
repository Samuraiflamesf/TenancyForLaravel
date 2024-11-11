<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Stancl\Tenancy\Contracts\Tenant;

class CreateTenantStorage implements ShouldQueue
{
    use Queueable;
    protected $tenant;


    /**
     * Create a new job instance.
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        $this->tenant->run(function ($tenant) {
            $storage_path = storage_path();

            mkdir("$storage_path/framework/cache", 0777, true);
        });
    }
}
