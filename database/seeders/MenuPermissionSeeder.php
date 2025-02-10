<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class MenuPermissionSeeder extends Seeder
{
    public function run()
    {
        $menus = DB::table('menu')->pluck('slug');

        foreach ($menus as $slug) {
            Permission::updateOrCreate(['name' => 'view-' . $slug]);
        }
    }
}
