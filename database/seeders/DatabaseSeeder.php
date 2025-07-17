<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '08123456789',
            'password' => Hash::make('admin')
        ]);

        $this->call([
            DivisionSeeder::class,
        ]);
    }
}
