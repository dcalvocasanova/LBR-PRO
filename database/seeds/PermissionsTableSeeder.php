<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Permission::create(['name' => 'CR_users']);
      Permission::create(['name' => 'CRUD_users']);
      Permission::create(['name' => 'CR_projects']);
      Permission::create(['name' => 'CRUD_projects']);
      Permission::create(['name' => 'CRUD_parameters']);
      Permission::create(['name' => 'CRUD_macroprocess']);
      Permission::create(['name' => 'CRUD_tasks']);
      Permission::create(['name' => 'CRUD_catalogs']);
      Permission::create(['name' => 'R_reports']);
      Permission::create(['name' => 'CRUD_psychosocial']);
      Permission::create(['name' => 'simple_user']);
    }
}
