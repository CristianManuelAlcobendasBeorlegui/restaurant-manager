<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Sashimi'],
            ['id' => 2, 'name' => 'Carpaccio'],
            ['id' => 3, 'name' => 'Tartar'],
            ['id' => 4, 'name' => 'Sopas'],
            ['id' => 5, 'name' => 'Ensaladas'],
            ['id' => 6, 'name' => 'Dimsum'],
            ['id' => 7, 'name' => 'Bao'],
            ['id' => 8, 'name' => 'Fritos'],
            ['id' => 9, 'name' => 'Arroces'],
            ['id' => 10, 'name' => 'Fideos'],
            ['id' => 11, 'name' => 'Futomaki'],
            ['id' => 12, 'name' => 'Fruto frito'],
            ['id' => 13, 'name' => 'Nigiri'],
            ['id' => 14, 'name' => 'Hosomaki'],
            ['id' => 15, 'name' => 'Postres'],
            ['id' => 16, 'name' => 'Bebidas'],
        ]);
    }
}
