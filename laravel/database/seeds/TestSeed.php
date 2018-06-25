<?php

use Illuminate\Database\Seeder;
use App\Models\Catagory;

class TestSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Catagory::class, 5)->create();
    }
}
