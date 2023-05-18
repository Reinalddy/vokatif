<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id'=> 1,
                'name'=> 'admin'
            ],
            [
                'id'=> 2,
                'name' => 'user'
            ]
        ];
        DB::table('roles')->insert($roles);
    }
}
