<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class AddLocalTestUserSeeder extends Seeder
{
    public function run(): void
    {
        if (App::environment() === 'local') {
            User::truncate();
            User::create([
                'email' => 'test@test.at',
                'name' => 'Vasea',
                'password' => bcrypt('test'),
            ]);
        }
    }
}
