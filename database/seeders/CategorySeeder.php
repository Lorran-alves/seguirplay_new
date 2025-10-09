<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'title' => 'Tik Tok',
                'slug' => Str::slug('Comprar seguidores Tik Tok'),
                'manual' => 0,
            ],
            [
                'title' => 'Youtube',
                'slug' => Str::slug('Comprar seguidores Youtube'),
                 'manual' => 0,
            ],
            [
                'title' => 'Kwai',
                'slug' => Str::slug('Comprar seguidores Kwai'),
                'manual' => 0,
            ],
            [
                'title' => 'Facebook',
                'slug' => Str::slug('Comprar seguidores Facebook'),
                'manual' => 0,
            ],
            [
                'title' => 'Instagram',
                'slug' => Str::slug('Comprar seguidores Instagram'),
                'manual' => 0,
            ]
        ]);
    }
}
