<?php

namespace Database\Seeders;

use App\Models\Product;
use Facade\FlareClient\Truncation\TruncationStrategy;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
        Product::factory()->count(40)->create();
    }
}
