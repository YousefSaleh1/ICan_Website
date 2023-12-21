<?php

namespace Database\Seeders;

use App\Models\Email;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $email = Email::creat([
                'email' => 'admain@gmail.com'
            ]);
            User::creat([
                'email_id' => $email->id,
                'password' => Hash::make('admin123'),
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
