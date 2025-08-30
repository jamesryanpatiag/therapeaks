<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ModelHasRole;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Disable checks

        User::factory()->create();

        ModelHasRole::factory()->create([
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Re-enable checks

    }
}
