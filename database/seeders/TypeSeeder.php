<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['FrontEnd', 'BackEnd', 'FullStack', 'UI/UX', 'Design'];
        foreach ($names as $name) {
            $type = new Type();
            $type->name = $name;
            $type->save();
        }
    }
}
