<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = [
            ['name' => 'HTML'],
            ['name' => 'CSS'],
            ['name' => 'BOOSTRAP'],
            ['name' => 'ES6'],
            ['name' => 'VUE'],
            ['name' => 'PHP'],
            ['name' => 'SQL'],
            ['name' => 'LARAVEL']
        ];
        foreach ($technologies as $technology) {
            $new_technology = new Technology();
            $new_technology->name = $technology['name'];
            $new_technology->save();
        }
    }
}
