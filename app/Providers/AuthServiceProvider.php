<?php

namespace App\Providers;

use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($role) {
            $role = Role::where('role', 'admin')->first();

            return auth()->user()->user_role->role_id === $role->id;
        });

        Gate::define('technician', function ($role) {
            $role = Role::where('role', 'technician')->first();

            return auth()->user()->user_role->role_id === $role->id;
        });

        Gate::define('user', function ($role) {
            $role = Role::where('role', 'user')->first();

            return auth()->user()->user_role->role_id === $role->id;
        });

        Gate::define('employee', function ($employee) {
            $employee = Position::where('position', 'Kepala Divisi IT')->first();

            return auth()->user()->employee->position_id !== $employee->id;
        });

        Gate::define('kepala', function ($position) {
            $position = Position::where('position', 'Kepala Divisi IT')->first();

            return auth()->user()->employee->position->id === $position->id;
        });

        Gate::define('manajer', function () {
            $role = Role::where('role', 'manager')->first();

            return auth()->user()->user_role->role_id === $role->id;
        });
    }
}
