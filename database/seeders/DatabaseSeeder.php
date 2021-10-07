<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) { 
           $id = DB::table('departments')->insertGetId([
                'name' => Str::random(3).' Department'
            ]);
            $number = rand(1,5); 
            for ($j=0; $j < $number; $j++) { 
                DB::table('hospitals')->insert([
                    'name' => Str::random(3).' Hospital',
                    'department_id'=>$id
                ]);
            }
        }
    }
}
