<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Table;
use App\Models\Waiter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Waiter::factory()->create();
        Table::factory(5)->create();
        Product::factory()->create([
            'name' => 'Água',
            'price' => 200
        ]);
        Product::factory()->create([
            'name' => 'Cerveja',
            'price' => 2000
        ]);
        Product::factory()->create([
            'name' => 'PF',
            'price' => 2000
        ]);
        Product::factory()->create([
            'name' => 'Brigadeiro',
            'price' => 300
        ]);
    }
}
