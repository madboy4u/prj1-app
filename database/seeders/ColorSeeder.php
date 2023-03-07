<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for($i=0; $i<100;$i++)
        {
        DB::table('colors')->insert(['color' => Str::random(20),
        ]);
    }
    //Color::create(['color' => 'Verde pisello']);
    //Color::create(['color' => Str::random(20)]);
    }
}
