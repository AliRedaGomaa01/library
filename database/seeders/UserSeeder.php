<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'a',
                'email' => 'a@a.a',
                'password' => bcrypt('a'),
                'is_admin' => true,
                ],
                [
                'name' => 'b',
                'email' => 'b@b.b',
                'password' => bcrypt('b')
                ],
                [
                'name' => 'c',
                'email' => 'c@c.c',
                'password' => bcrypt('c')
                ],
                [
                'name' => 'd',
                'email' => 'd@d.d',
                'password' => bcrypt('d')
                ],
        ];
        
        foreach($users as $user){
            \App\Models\User::create(
                $user
            );
        }
    }
}
