<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(TypeTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(UserTableSeeder::class);

        factory('App\Models\Content', 50)->create();

        Model::reguard();
    }
}
