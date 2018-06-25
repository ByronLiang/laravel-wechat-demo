<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::getModel()->delete();
        Admin::create([
            'account' => 'admin',
            'password' => '123456',
        ]);
    }
}
