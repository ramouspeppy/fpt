<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Cabang', 'Pusat', 'Admin'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
