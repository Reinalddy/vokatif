<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatgoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id'=> 1,
                'name'=> 'Fantasy'
            ],
            [
                'id'=> 2,
                'name' => 'Gore'
            ]
        ];

        DB::table('categories')->insert($categories);
    }
}
