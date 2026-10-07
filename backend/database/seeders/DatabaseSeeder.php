<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder
 *
 * Entry point for all seeders. Run with: php artisan db:seed
 *
 * NOTE: No fake CRM records are created in the foundation.
 *       Seeders run only system-required data (e.g., default roles/permissions).
 *       Business-data seeders are added with domain modules.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // System roles and permissions — added when Auth/RBAC module is built
            // RolePermissionSeeder::class,
        ]);
    }
}
